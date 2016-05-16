<?php

namespace App\Http\Modules\School\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\School\Models\MarkSheet;
use App\Http\Modules\School\Requests\MarkSheetFormRequest;

class MarkSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $markSheet = new MarkSheet;
        return view('modules.school.MarkSheet.list', compact('markSheet'));
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

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param MarkSheetFormRequest $request
    //  * @param  int $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(MarkSheetFormRequest $request, $id)
    // {
    //     $markSheet = MarkSheet::findOrFail($id);

    //     if ($markSheet->update($request->input())) {
    //         return redirect('/cabinet/mark-sheet');
    //     }

    //     return redirect(url('/cabinet/mark-sheet/edit', compact('id')))
    //         ->withErrors($markSheet->getErrors());
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     $markSheet = new MarkSheet;
    //     return view('modules.school.MarkSheet.form', compact('markSheet'));
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param MarkSheetFormRequest $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(MarkSheetFormRequest $request)
    // {
    //     $markSheet = new MarkSheet($request->input());

    //     if ($markSheet->save()) {
    //         return redirect('/cabinet/mark-sheet');
    //     }

    //     return redirect('/cabinet/mark-sheet/create')->withErrors($markSheet->getErrors());
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     $markSheet = MarkSheet::findOrFail($id);

    //     if ($markSheet->delete()) {
    //         return redirect('/cabinet/mark-sheet');
    //     }

    //     return redirect('/cabinet/mark-sheet')->withErrors($markSheet->getErrors());
    // }
}
