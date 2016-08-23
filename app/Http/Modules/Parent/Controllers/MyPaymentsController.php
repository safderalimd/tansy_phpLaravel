<?php

namespace App\Http\Modules\Parent\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Parent\Models\MyPayments;

class MyPaymentsController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . MyPayments::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inbox = new MyPayments($request->input());
        $inbox->loadData();

        if ($inbox->isFirstPage()) {
            return view('modules.parent.MyPayments.list', compact('inbox'));

        } else {
            return view('modules.parent.MyPayments.messages', compact('inbox'));
        }
    }
}
