<?php

namespace App\Http\Modules\Communication\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Communication\Models\SendMail;

class SendMailController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . SendMail::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inbox = new SendMail($request->input());
        $inbox->loadData();

        if ($inbox->isFirstPage()) {
            return view('modules.communication.SendMail.list', compact('inbox'));

        } else {
            return view('modules.communication.SendMail.messages', compact('inbox'));
        }
    }

    public function detail(Request $request)
    {
        $inbox = new SendMail($request->input());
        return view('modules.communication.SendMail.detail', compact('inbox'));
    }

    public function delete(Request $request)
    {
        $inbox = new SendMail($request->input());
        $inbox->deleteMessage();
        flash('Messages Deleted!');
        return redirect('/cabinet/send-mail');
    }
}
