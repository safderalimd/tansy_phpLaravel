<?php

namespace App\Http\Modules\thirdparty\omr\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\thirdparty\omr\Models\MarkSheetLoad;
use App\Http\Modules\thirdparty\omr\Requests\MarkSheetLoadFormRequest;

class MarkSheetLoadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $markSheet = new MarkSheetLoad;
        return view('thirdparty.omr.school.MarkSheetLoad.list', compact('markSheet'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $markSheet = new MarkSheetLoad;
        return view('thirdparty.omr.school.MarketSheetLoad.form', compact('markSheet'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductFormRequest $request)
    {
        $markSheet = new MarkSheetLoad($request->input());

        if ($markSheet->save()) {
            return redirect('/cabinet/mark-sheet---load');
        }

        return redirect('/cabinet/mark-sheet---load/create')->withErrors($markSheet->getErrors());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $markSheet = MarkSheetLoad::findOrFail($id);
        return view('thirdparty.omr.school.MarketSheetLoad.form', compact('markSheet'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductFormRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductFormRequest $request, $id)
    {
        $markSheet = MarkSheetLoad::findOrFail($id);

        if ($markSheet->update($request->input())) {
            return redirect('/cabinet/mark-sheet---load');
        }

        return redirect(url('/cabinet/mark-sheet---load/edit', compact('id')))
            ->withErrors($markSheet->getErrors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $markSheet = MarkSheetLoad::findOrFail($id);

        if ($markSheet->delete()) {
            return redirect('/cabinet/mark-sheet---load');
        }

        return redirect('/cabinet/mark-sheet---load')->withErrors($markSheet->getErrors());
    }
}
