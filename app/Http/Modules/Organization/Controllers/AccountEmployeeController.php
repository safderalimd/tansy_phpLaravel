<?php

namespace App\Http\Modules\Organization\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Organization\Models\AccountEmployee;
use App\Http\Modules\Organization\Requests\AccountEmployeeFormRequest;

class AccountEmployeeController extends Controller
{
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
        $account = new AccountEmployee($request->input());
        $account->save();
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
        $account = AccountEmployee::findOrFail($id);
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
        $account = new AccountEmployee;
        $account->setAttribute('AccountEmployee_entity_id', $id);
        $account->update($request->input());
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
        $account = AccountEmployee::findOrFail($id);
        $account->delete();
        return redirect('/cabinet/account-employee');
    }
}
