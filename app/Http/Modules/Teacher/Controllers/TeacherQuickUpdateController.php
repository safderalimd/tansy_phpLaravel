<?php

namespace App\Http\Modules\Teacher\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Teacher\Models\TeacherQuickUpdate;

class TeacherQuickUpdateController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . TeacherQuickUpdate::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $update = new TeacherQuickUpdate($request->input());
        return view('modules.teacher.TeacherQuickUpdate.list', compact('update'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $update = new TeacherQuickUpdate($request->input());
        $update->update();
        return ['success' => true];
    }
}
