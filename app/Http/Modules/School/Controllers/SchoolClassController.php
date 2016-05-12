<?php

namespace App\Http\Modules\School\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\School\Models\SchoolClass;
use App\Http\Modules\School\Requests\SchoolClassFormRequest;
use DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SchoolClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = DB::connection('secondDB')->select(
            'SELECT  class_entity_id, class_name, class_group, class_category
             FROM view_sch_class_grid
             ORDER BY class_name DESC;'
        );

        return view('modules.school.schoolClass.list', ['data' => $rows]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new SchoolClass();
        $facility = $this->getFacility();
        $ClassGroup = $this->getClassGroup();
        $ClassCategory = $this->getClassCategory();
        
        return view('modules.school.schoolClass.form', ['model' => $model, 'facility' => $facility, 'ClassGroup' => $ClassGroup, 'ClassCategory' => $ClassCategory]);
    }

//    public function create()
//    {
//    	$model = new SchoolClass();
//    	$ClassGroup = $this->getClassGroup();
//
//    	return view('modules.school.schoolClass.form', ['model' => $model, 'ClassGroup' => $ClassGroup]);
//    }
//
//    public function create()
//    {
//    	$model = new SchoolClass();
//    	$ClassCategory = $this->getClassCategory();
//
//    	return view('modules.school.schoolClass.form', ['model' => $model, 'ClassCategory' => $ClassCategory]);
//    }



    /**
     * Store a newly created resource in storage.
     *
     * @param FiscalYearFormRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(SchoolClassFormRequest $request)
    {
        $params = $request->input();

        $model = new SchoolClass($params);
        if ($model->save()) {
			 return redirect(url('/cabinet/class'));
           // return redirect(url('/cabinet/class/edit', ['id' => $model->getID()]));
        }

        return redirect('/cabinet/class/create')->withErrors($model->getErrors());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->getModel($id);
        $facility = $this->getFacility();
        $ClassGroup = $this->getClassGroup();
        $ClassCategory = $this->getClassCategory();

        $t = $model->getClassGroups();

        return view('modules.school.schoolClass.form', ['model' => $model, 'facility' => $facility, 'ClassGroup' => $ClassGroup, 'ClassCategory' => $ClassCategory]);
    }

//    public function edit($id)
//    {
//    	$model = $this->getModel($id);
//    	$ClassGroup = $this->getClassGroup();
//
//    	return view('modules.school.schoolClass.form', ['model' => $model, 'ClassGroup' => $ClassGroup]);
//    }
//
//    public function edit($id)
//    {
//    	$model = $this->getModel($id);
//    	$ClassCategory = $this->getClassCategory();
//
//    	return view('modules.school.schoolClass.form', ['model' => $model, 'ClassCategory' => $ClassCategory]);
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param FiscalYearFormRequest|Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(SchoolClassFormRequest $request, $id)
    {
        $params = $request->input();
		
		//dd($params);
        $params['ClassEntityID'] = $id;

        $model = new SchoolClass($params);

        if ($model->save()) {
           // return redirect(url('/cabinet/class/edit', ['id' => $model->getID()]));
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
        $model = $this->getModel($id);

        if ($model->delete()) {
            return redirect('/cabinet/class');
        }

        return redirect('/cabinet/class')->withErrors($model->getErrors());
    }

    /**
     * @param int $id
     * @return SchoolClass
     */
    private function getModel($id)
    {
        $model = SchoolClass::getByID($id);

        if ($model === null) {
            throw new NotFoundHttpException('Not found entity object');
        }

        return $model;
    }

    private function getFacility()
    {
        $facility = DB::connection('secondDB')->select(
            'SELECT  facility_entity_id, facility_name
             FROM view_org_facility_lkp
             ORDER BY facility_name;'
        );

        return $facility;
    }
    
    private function getClassGroup()
    {
    	$ClassGroup = DB::connection('secondDB')->select(
    			'SELECT  class_group_entity_id, class_group
             FROM view_sch_lkp_class_group
             ORDER BY class_group;'
    			);
    
    	return $ClassGroup;
    }

    private function getClassCategory()
    {
    	$ClassCategory = DB::connection('secondDB')->select(
    			'SELECT  class_category_entity_id, class_category
             FROM view_sch_lkp_class_category
             ORDER BY class_category;'
    			);
    
    	return $ClassCategory;
    }
    
}