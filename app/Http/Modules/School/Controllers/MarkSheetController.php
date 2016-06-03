<?php

namespace App\Http\Modules\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\School\Models\MarkSheet;
use App\Http\Modules\School\Requests\MarkSheetFormRequest;
use App\Http\Modules\School\Requests\MarkSheetDeleteFormRequest;

class MarkSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $examId = $request->input('eid');
        $markSheet = new MarkSheet;
        $markSheet->setExamId($examId);
        return view('modules.school.MarkSheet.list', compact('markSheet', 'examId'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit(MarkSheetFormRequest $request)
    {
        $markSheet = new MarkSheet($request->input());
        return view('modules.school.MarkSheet.form', compact('markSheet'));
    }

    /**
     * Lock.
     *
     * @param MarkSheetFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function lock(MarkSheetFormRequest $request)
    {
        $markSheet = new MarkSheet($request->input());

        if ($markSheet->lock()) {
            return redirect('/cabinet/mark-sheet');
        }

        return redirect(url('/cabinet/mark-sheet'))->withErrors($markSheet->getErrors());
    }

    /**
     * Unlock.
     *
     * @param MarkSheetFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function unlock(MarkSheetFormRequest $request)
    {
        $markSheet = new MarkSheet($request->input());

        if ($markSheet->unlock()) {
            return redirect('/cabinet/mark-sheet');
        }

        return redirect(url('/cabinet/mark-sheet'))->withErrors($markSheet->getErrors());
    }

    /**
     * Save.
     *
     * @param MarkSheetDeleteFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function save(MarkSheetDeleteFormRequest $request)
    {
        $markSheet = new MarkSheet($request->input());

        if ($markSheet->saveMarksheet()) {
            return redirect('/cabinet/mark-sheet');
        }

        return \Redirect::back()->withErrors($markSheet->getErrors());
    }
}
