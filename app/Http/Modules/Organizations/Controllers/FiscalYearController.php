<?php

namespace App\Http\Modules\Organizations\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Organizations\Models\FiscalYear;
use App\Http\Modules\Organizations\Requests\FiscalYearFormRequest;
use DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FiscalYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = DB::connection('secondDB')->select(
            'SELECT  fiscal_year_entity_id, fiscal_year, start_date, end_date, current_fiscal_year
             FROM view_org_fiscal_year_detail
             ORDER BY start_date DESC;'
        );

        return view('modules.organizations.fiscalYear.list', ['data' => $rows]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new FiscalYear();
        $facility = $this->getFacility();

        return view('modules.organizations.fiscalYear.form', ['model' => $model, 'facility' => $facility]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FiscalYearFormRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(FiscalYearFormRequest $request)
    {
        $params = $request->input();

        $model = new FiscalYear($params);
        if ($model->save()) {
            return redirect(url('/cabinet/fiscalYear/edit', ['id' => $model->getID()]));
        }

        return redirect('/cabinet/fiscalYear/create')->withErrors($model->getErrors());
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

        return view('modules.organizations.fiscalYear.form', ['model' => $model, 'facility' => $facility]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FiscalYearFormRequest|Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(FiscalYearFormRequest $request, $id)
    {
        $params = $request->input();
        $params['entityID'] = $id;

        $model = new FiscalYear($params);

        if ($model->save()) {
            return redirect(url('/cabinet/fiscalYear/edit', ['id' => $model->getID()]));
        }

        return redirect('/cabinet/fiscalYear/edit')->withErrors($model->getErrors());
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
            return redirect('/cabinet/fiscalYear');
        }

        return redirect('/cabinet/fiscalYear')->withErrors($model->getErrors());
    }

    /**
     * @param int $id
     * @return FiscalYear
     */
    private function getModel(int $id)
    {
        $model = FiscalYear::getByID($id);

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
}