<?php

namespace App\Http\Modules\loaddata\School\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\loaddata\School\Models\StudentData;
use App\Http\Modules\loaddata\School\Models\ExcelValueBinder;
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

    public function store(StudentDataFormRequest $request)
    {
        $studentData = new StudentData($request->input());

        // get excel to db column mapping
        $mapping = $studentData->columnMapping();

        // save the uploaded file
        $file = $request->file('attachment');
        $newName = time().uniqid().'.'.$file->clientExtension();
        $savedFile = $file->move(storage_path('uploads/student-data'), $newName);

        // parse the uploaded file

        $binder = new ExcelValueBinder;
        $excel = \Excel::setValueBinder($binder);

        $sheets = $excel->load($savedFile->getRealPath())->get();

        dd($sheets->first()->toArray());


        $sheets->first()->each(function ($item, $key) {
            dd($item->all());
        });

        // delete the uploaded file
        unlink($savedFile->getRealPath());
    }

}
