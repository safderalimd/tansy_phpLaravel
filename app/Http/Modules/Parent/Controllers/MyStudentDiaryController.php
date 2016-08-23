<?php

namespace App\Http\Modules\Parent\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Parent\Models\MyStudentDiary;

class MyStudentDiaryController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . MyStudentDiary::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inbox = new MyStudentDiary($request->input());
        $inbox->loadData();
        dd($inbox);

        if ($inbox->isFirstPage()) {
            return view('modules.parent.MyStudentDiary.list', compact('inbox'));

        } else {
            return view('modules.parent.MyStudentDiary.messages', compact('inbox'));
        }
    }
}
