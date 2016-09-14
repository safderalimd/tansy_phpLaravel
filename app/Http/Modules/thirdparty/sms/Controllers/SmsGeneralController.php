<?php

namespace App\Http\Modules\thirdparty\sms\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\thirdparty\sms\Models\SendSmsGeneral;
use App\Http\Models\Grid;

class SmsGeneralController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . SendSmsGeneral::staticScreenId());
    }

    public function general(Request $request)
    {
        $grid = new Grid('/' . $request->path());
        $grid->setAttribute('input_value_filter2', $request->input('aei'));
        $grid->setAttribute('input_value_filter1', $request->input('art'));
        $grid->fill($request->input());
        $grid->loadData();

        if (is_null($request->input('aei')) || is_null($request->input('art')) || is_null($request->input('sti'))) {
            $grid->emptyRows();
        }

        $sms = new SendSmsGeneral($request->input());

        $options = [
            'beforeGridInclude'  => 'thirdparty.sms.SendSms.GeneralV1.before-grid-include',
            'headerFirstInclude' => 'thirdparty.sms.SendSms.GeneralV1.header-first-include',
            'rowFirstInclude'    => 'thirdparty.sms.SendSms.GeneralV1.row-first-include',
            'afterGridInclude'   => 'thirdparty.sms.SendSms.GeneralV1.after-grid-include',
            'scriptsInclude'     => 'thirdparty.sms.SendSms.GeneralV1.scripts-include',
            'datatableOff'       => true,
        ];

        return view('grid.list', compact('grid', 'options', 'sms'));
    }

    public function sendGeneral(Request $request)
    {
        $this->validate($request, ['student_ids' => 'required|string']);
        $this->validate($request, ['common_message' => 'required|string|max:160']);

        $grid = new Grid('/' . $request->path());
        $grid->setAttribute('input_value_filter2', $request->input('aei'));
        $grid->setAttribute('input_value_filter1', $request->input('art'));
        $grid->fill($request->input());
        $grid->loadData();

        $sms = new SendSmsGeneral($request->input());
        $dbRows = $grid->rows();
        $ids = $request->input('student_ids');
        $ids = explode(',', $ids);
        $text = $request->input('common_message');

        // get only rows selected
        $validRows = array_filter($dbRows, function($row) use ($ids) {
            return in_array($row['account_entity_id'], $ids);
        });

        // apply the message to the rows
        $validRows = array_map(function($row) use ($text) {
            $row['sms_text'] = $text;
            $row['api_status'] = '';
            return $row;
        }, $validRows);

        flash('General SMS Sent!');
        return $this->sendSmsToStudents($sms, $validRows, true, $text, true);
    }
}
