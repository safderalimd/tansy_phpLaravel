<?php

namespace App\Http\Modules\Communication\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Communication\Models\Inbox;
use App\Http\Modules\Communication\Requests\ProductFormRequest;

class InboxController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . Inbox::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inbox = new Inbox($request->input());
        $inbox->loadData();

        if ($inbox->isFirstPage()) {
            return view('modules.communication.Inbox.list', compact('inbox'));

        } else {
            return view('modules.communication.Inbox.messages', compact('inbox'));
        }
    }

    public function detail(Request $request)
    {
        $inbox = new Inbox($request->input());
        return view('modules.communication.Inbox.detail', compact('inbox'));
    }

    public function newMessage(Request $request)
    {
        $inbox = new Inbox;
        $this->checkSendPermission($inbox);
        return view('modules.communication.Inbox.new', compact('inbox'));
    }

    public function send(Request $request)
    {
        $inbox = new Inbox($request->input());
        $this->checkSendPermission($inbox);
        $inbox->send();
        flash('Message Sent!');
        return redirect('/cabinet/inbox');
    }

    public function delete(Request $request)
    {
        $inbox = new Inbox($request->input());
        $inbox->deleteMessage();
        flash('Messages Deleted!');
        return redirect('/cabinet/inbox');
    }

    public function checkSendPermission($inbox)
    {
        if (!$inbox->userCanSendMessage()) {
            die("Unauthorized. You don't have permission to access this screen.");
        }
    }
}
