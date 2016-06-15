<?php

namespace App\Http\Modules\Organization\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Organization\Models\FiscalYear;
use App\Http\Modules\Organization\Requests\FiscalYearFormRequest;

class FiscalYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fiscalYear = new FiscalYear;
        return view('modules.organization.FiscalYear.list', compact('fiscalYear'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fiscalYear = new FiscalYear;
        return view('modules.organization.FiscalYear.form', compact('fiscalYear'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FiscalYearFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FiscalYearFormRequest $request)
    {
        $fiscalYear = new FiscalYear;
        $fiscalYear->setAttribute('current_fiscal_year', 0);

        $fiscalYear->save($request->input());
        flash('Fiscal Year Added!');
        return redirect('/cabinet/fiscal-year');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fiscalYear = FiscalYear::findOrFail($id);
        $fiscalYear->loadData();
        return view('modules.organization.FiscalYear.form', compact('fiscalYear'));
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
        $fiscalYear = new FiscalYear;
        $fiscalYear->setAttribute('fiscal_year_entity_id', $id);
        $fiscalYear->setAttribute('current_fiscal_year', 0);

        $fiscalYear->update($request->input());
        flash('Fiscal Year Updated!');
        return redirect('/cabinet/fiscal-year');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fiscalYear = FiscalYear::findOrFail($id);
        $fiscalYear->delete();
        flash('Fiscal Year Deleted!');
        return redirect('/cabinet/fiscal-year');
    }
}
