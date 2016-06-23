<?php

namespace App\Http\Modules\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\School\Models\MoveStudent;
use App\Http\Modules\School\Requests\MoveStudentFormRequest;

class MoveStudentController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . MoveStudent::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $move = new MoveStudent($request->input());
        return view('modules.school.MoveStudent.list', compact('move'));
    }

    /**
     * Move students.
     *
     * @param MoveStudentFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function move(MoveStudentFormRequest $request)
    {
        $move = new MoveStudent($request->input());
        $move->move();
        flash('Students Moved!');
        return redirect('/cabinet/move-student');
    }
}
