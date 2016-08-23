<?php

namespace App\Http\Modules\Parent\Controllers;

use Illuminate\Http\Request;
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
    public function index(Request $request)
    {
        $inbox = new MyExamSyllabus($request->input());
        $inbox->loadData();

        if ($inbox->isFirstPage()) {
            return view('modules.parent.MyExamSyllabus.list', compact('inbox'));

        } else {
            return view('modules.parent.MyExamSyllabus.messages', compact('inbox'));
        }
    }
}
