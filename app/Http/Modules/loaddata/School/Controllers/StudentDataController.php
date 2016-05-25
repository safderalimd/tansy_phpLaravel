<?php

namespace App\Http\Modules\loaddata\School\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\loaddata\School\Models\StudentData;
use App\Http\Modules\loaddata\School\Requests\StudentDataFormRequest;

class StudentDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $studentData = new StudentData;
        return view('loaddata.school.StudentData.list', compact('studentData'));
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     $studentData = new StudentData;
    //     return view('loaddata.school.StudentData.form', compact('studentData'));
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param ProductFormRequest $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(ProductFormRequest $request)
    // {
    //     $studentData = new StudentData($request->input());

    //     if ($studentData->save()) {
    //         return redirect('/cabinet/load-student-data');
    //     }

    //     return redirect('/cabinet/load-student-data/create')->withErrors($studentData->getErrors());
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     $studentData = StudentData::findOrFail($id);
    //     return view('loaddata.school.StudentData.form', compact('studentData'));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param ProductFormRequest $request
    //  * @param  int $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(ProductFormRequest $request, $id)
    // {
    //     $studentData = StudentData::findOrFail($id);

    //     if ($studentData->update($request->input())) {
    //         return redirect('/cabinet/load-student-data');
    //     }

    //     return redirect(url('/cabinet/load-student-data/edit', compact('id')))
    //         ->withErrors($studentData->getErrors());
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     $studentData = StudentData::findOrFail($id);

    //     if ($studentData->delete()) {
    //         return redirect('/cabinet/load-student-data');
    //     }

    //     return redirect('/cabinet/load-student-data')->withErrors($studentData->getErrors());
    // }
}
