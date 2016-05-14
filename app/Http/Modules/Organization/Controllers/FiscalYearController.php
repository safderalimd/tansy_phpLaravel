<?php

namespace App\Http\Modules\Organization\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Organization\Models\FiscalYear;
use App\Http\Modules\Organization\Requests\FiscalYearFormRequest;
use App\Http\Modules\Organization\FiscalYearRepository;

class FiscalYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  FiscalYearRepository $repo
     * @return \Illuminate\Http\Response
     */
    public function index(FiscalYearRepository $repo)
    {
        $rows = $repo->getAllFiscalYears();
        return view('modules.organizations.fiscal-year.list', ['data' => $rows]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  FiscalYearRepository $repo
     * @return \Illuminate\Http\Response
     */
    public function create(FiscalYearRepository $repo)
    {
        $model = new FiscalYear();
        $facility = $repo->getFacilities();

        return view('modules.organizations.fiscal-year.form', ['model' => $model, 'facility' => $facility]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FiscalYearFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FiscalYearFormRequest $request)
    {
        $params = $request->input();

        $model = new FiscalYear($params);
        if ($model->save()) {
            return redirect('/cabinet/fiscal-year');
        }

        return redirect('/cabinet/fiscal-year/create')->withErrors($model->getErrors());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  FiscalYearRepository $repo
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(FiscalYearRepository $repo, $id)
    {
        $model = FiscalYear::findOrFail($id);
        $facility = $repo->getFacilities();

        return view('modules.organizations.fiscal-year.form', ['model' => $model, 'facility' => $facility]);
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
            return redirect('/cabinet/fiscal-year');
        }

        return redirect(url('/cabinet/fiscal-year/edit', ['id' => $model->getID()]))->withErrors($model->getErrors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = FiscalYear::findOrFail($id);

        if ($model->delete()) {
            return redirect('/cabinet/fiscal-year');
        }

        return redirect('/cabinet/fiscal-year')->withErrors($model->getErrors());
    }
}
