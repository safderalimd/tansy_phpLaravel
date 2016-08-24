<?php

namespace App\Http\Modules\Parent\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Parent\Models\MyExamSchedule;

class MyExamScheduleController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . MyExamSchedule::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inbox = new MyExamSchedule($request->input());
        $inbox->loadData();

        if ($inbox->isFirstPage()) {
            return view('modules.parent.MyExamSchedule.list', compact('inbox'));

        } else {
            return view('modules.parent.MyExamSchedule.messages', compact('inbox'));
        }
    }
}
