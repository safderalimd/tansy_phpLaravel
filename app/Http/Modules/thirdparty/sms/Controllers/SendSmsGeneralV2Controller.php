<?php

namespace App\Http\Modules\thirdparty\sms\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\thirdparty\sms\Models\SendSmsGeneralV2;
use App\Http\Models\Grid;
use Exception;

class SendSmsGeneralV2Controller extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . SendSmsGeneralV2::staticScreenId());
    }

    public function generalV2(Request $request)
    {
        $grid = new Grid('/' . $request->path());
        $grid->setAttribute('input_value_filter2', $request->input('aei'));
        $grid->setAttribute('input_value_filter1', $request->input('art'));
        $grid->fill($request->input());
        $grid->loadData();

        if (is_null($request->input('aei')) || is_null($request->input('art')) || is_null($request->input('sti'))) {
            $grid->emptyRows();
        }

        $sms = new SendSmsGeneralV2($request->input());

        $options = [
            'beforeGridInclude'  => 'thirdparty.sms.SendSms.GeneralV2.before-grid-include',
            'headerFirstInclude' => 'thirdparty.sms.SendSms.GeneralV2.header-first-include',
            'headerLastInclude'  => 'thirdparty.sms.SendSms.GeneralV2.header-last-include',
            'rowFirstInclude'    => 'thirdparty.sms.SendSms.GeneralV2.row-first-include',
            'rowLastInclude'     => 'thirdparty.sms.SendSms.GeneralV2.row-last-include',
            'afterGridInclude'   => 'thirdparty.sms.SendSms.GeneralV2.after-grid-include',
            'scriptsInclude'     => 'thirdparty.sms.SendSms.GeneralV2.scripts-include',
            'datatableOff'       => true,
        ];

        return view('grid.list', compact('grid', 'options', 'sms'));
    }

    public function sendGeneralV2(Request $request)
    {
        $ids = [];
        $messages = json_decode($request->input('text_messages'));

        // validate message lenght
        foreach ($messages as $message) {
            $ids[] = $message->id;
            if (strlen($message->message) > 160) {
                throw new Exception("Message is too long. Max size is 160 chars.");
            }
        }

        $grid = new Grid('/' . $request->path());
        $grid->setAttribute('input_value_filter2', $request->input('aei'));
        $grid->setAttribute('input_value_filter1', $request->input('art'));
        $grid->fill($request->input());
        $grid->loadData();

        $sms = new SendSmsGeneralV2($request->input());
        $dbRows = $grid->rows();

        // get only rows selected
        $validRows = array_filter($dbRows, function($row) use ($ids) {
            return in_array($row['account_entity_id'], $ids);
        });

        // apply the message to the rows
        $validRows = array_map(function($row) use ($messages) {
            $row['sms_text'] = '';
            $row['api_status'] = '';
            foreach ($messages as $message) {
                if ($row['account_entity_id'] == $message->id) {
                    $row['sms_text'] = $message->message;
                    break;
                }
            }
            return $row;
        }, $validRows);

        flash('SMS Sent!');
        return $this->sendSmsToStudents($sms, $validRows, false, '', true);
    }
}
