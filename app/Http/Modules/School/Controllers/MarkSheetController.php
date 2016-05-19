<?php

namespace App\Http\Modules\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\School\Models\MarkSheet;
use App\Http\Modules\School\Requests\MarkSheetFormRequest;

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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $markSheet = MarkSheet::findOrFail($id);
        dd($markSheet);
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
}
