<?php

namespace App\Http\Modules\loaddata\School\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\loaddata\School\Models\StudentData;
use App\Http\Modules\loaddata\School\Requests\StudentDataFormRequest;
use Excel;
use Carbon\Carbon;

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
        $mappings = $studentData->columnMapping();

        // save the uploaded file
        $file = $request->file('attachment');
        $newName = time().uniqid().'.'.$file->clientExtension();
        $savedFile = $file->move(storage_path('uploads/student-data'), $newName);

        $insertRows = [];

        // parse the excel
        $rows = Excel::load($savedFile->getRealPath())->get()->first();

        // map db mappins to excel columns
        $insertRow = [];
        foreach ($rows as $row) {

            foreach ($mappings as $mapping) {
                $value = $row->get($mapping['file_column_name']);
                if ($value instanceof Carbon) {
                    $value = $value->toDateString();
                }
                $insertRow[$mapping['table_column_name']] = $value;
            }

            $insertRow['facility_entity_id'] = $studentData->facility_entity_id;
            $insertRows[] = $insertRow;
        }

        $studentData->add($insertRows);

        // delete the uploaded file
        unlink($savedFile->getRealPath());

        $studentData->uploadComplete();

        flash('Students Added!');
        return redirect('/cabinet/admission');
    }

}
