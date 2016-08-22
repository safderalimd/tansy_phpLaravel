<?php

namespace App\Http\Modules\Parent\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Parent\Models\MyExamSyllabus;

class MyExamSyllabusController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . MyExamSyllabus::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $history = new MyExamSyllabus;
        d($history->grid());
        dd($history);
        return view('modules.parent.MyExamSyllabus.list', compact('history'));
    }
}
