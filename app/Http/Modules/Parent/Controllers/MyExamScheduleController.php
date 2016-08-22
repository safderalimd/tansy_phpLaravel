<?php

namespace App\Http\Modules\Parent\Controllers;

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
    public function index()
    {
        $history = new MyExamSchedule;
        d($history->grid());
        dd($history);
        return view('modules.parent.MyExamSchedule.list', compact('history'));
    }
}
