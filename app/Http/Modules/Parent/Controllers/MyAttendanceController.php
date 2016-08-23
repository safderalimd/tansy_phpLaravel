<?php

namespace App\Http\Modules\Parent\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Parent\Models\MyAttendance;

class MyAttendanceController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . MyAttendance::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inbox = new MyAttendance($request->input());
        $inbox->loadData();

        if ($inbox->isFirstPage()) {
            return view('modules.parent.MyAttendance.list', compact('inbox'));

        } else {
            return view('modules.parent.MyAttendance.messages', compact('inbox'));
        }
    }
}
