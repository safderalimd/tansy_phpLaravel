<?php

namespace App\Http\Modules\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\School\Models\SchoolClass;
use App\Http\Modules\School\Requests\SchoolClassFormRequest;
use App\Http\Modules\School\Repositories\SchoolClassRepository;

class SchoolClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  SchoolClassRepository $repo
     * @return \Illuminate\Http\Response
     */
    public function index(SchoolClassRepository $repo)
    {
        $rows = $repo->getAllSchoolCalsses();
        return view('modules.school.SchoolClass.list', ['data' => $rows]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  SchoolClassRepository $repo
     * @return \Illuminate\Http\Response
     */
    public function create(SchoolClassRepository $repo)
    {
        $model = new SchoolClass();
        $facility = $repo->getFacilities();
        $ClassGroup = $repo->getClassGroups();
        $ClassCategory = $repo->getClassCategories();

        return view('modules.school.SchoolClass.form', ['model' => $model, 'facility' => $facility, 'ClassGroup' => $ClassGroup, 'ClassCategory' => $ClassCategory]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SchoolClassFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SchoolClassFormRequest $request)
    {
        $params = $request->input();

        $model = new SchoolClass($params);
        if ($model->save()) {
			return redirect(url('/cabinet/class'));
        }

        return redirect('/cabinet/class/create')->withErrors($model->getErrors());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  SchoolClassRepository $repo
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SchoolClassRepository $repo, $id)
    {
        $model = SchoolClass::findOrFail($id);
        $facility = $repo->getFacilities();
        $ClassGroup = $repo->getClassGroups();
        $ClassCategory = $repo->getClassCategories();

        // TODO: Fix this next line
        $t = $model->getClassGroups();

        return view('modules.school.SchoolClass.form', ['model' => $model, 'facility' => $facility, 'ClassGroup' => $ClassGroup, 'ClassCategory' => $ClassCategory]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SchoolClassFormRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(SchoolClassFormRequest $request, $id)
    {
        $params = $request->input();
        $params['ClassEntityID'] = $id;

        $model = new SchoolClass($params);

        if ($model->save()) {
            return redirect(url('/cabinet/class'));
        }

        return redirect(url('/cabinet/class/edit', ['id' => $model->getID()]))->withErrors($model->getErrors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = SchoolClass::findOrFail($id);

        if ($model->delete()) {
            return redirect('/cabinet/class');
        }

        return redirect('/cabinet/class')->withErrors($model->getErrors());
    }
}
