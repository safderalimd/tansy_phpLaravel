<?php

namespace App\Http\Modules\Organization\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Organization\Models\AccountEmployee;
use App\Http\Modules\Organization\Requests\AccountEmployeeFormRequest;

class AccountEmployeeController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . AccountEmployee::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account = new AccountEmployee;
        return view('modules.organization.AccountEmployee.list', compact('account'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $account = new AccountEmployee;
        return view('modules.organization.AccountEmployee.form', compact('account'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AccountEmployeeFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountEmployeeFormRequest $request)
    {
        $input = $request->input();
        $input['city_area'] = $request->input('city_area_new');

        $account = new AccountEmployee;
        $account->setAttribute('active', 0);
        $account->setAttribute('login_active', 0);
        $account->save($input);
        flash('Employee Added!');
        return redirect('/cabinet/account-employee');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $account = AccountEmployee::find($id);
        $account->loadData();
        return view('modules.organization.AccountEmployee.form', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AccountEmployeeFormRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AccountEmployeeFormRequest $request, $id)
    {
        $input = $request->input();
        $input['city_area'] = $request->input('city_area_new');

        $account = new AccountEmployee;
        $account->setAttribute('account_entity_id', $id);
        $account->setAttribute('active', 0);
        $account->setAttribute('login_active', 0);
        $account->update($input);
        flash('Employee Updated!');
        return redirect('/cabinet/account-employee');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account = AccountEmployee::find($id);
        $account->delete();
        flash('Employee Deleted!');
        return redirect('/cabinet/account-employee');
    }
}
