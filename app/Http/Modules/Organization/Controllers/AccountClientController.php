<?php

namespace App\Http\Modules\Organization\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Organization\Models\AccountClient;
use App\Http\Modules\Organization\Requests\AccountClientFormRequest;

class AccountClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account = new AccountClient;
        return view('modules.organization.AccountClient.list', compact('account'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $account = new AccountClient;
        return view('modules.organization.AccountClient.form', compact('account'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AccountClientFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountClientFormRequest $request)
    {
        $input = $request->input();
        $input['city_area'] = $request->input('city_area_new');

        $account = new AccountClient;
        $account->setAttribute('active', 0);
        $account->save($input);
        flash('Client Created!');
        return redirect('/cabinet/account-client');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $account = AccountClient::findOrFail($id);
        $account->loadData();
        return view('modules.organization.AccountClient.form', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AccountClientFormRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AccountClientFormRequest $request, $id)
    {
        $input = $request->input();
        $input['city_area'] = $request->input('city_area_new');

        $account = new AccountClient;
        $account->setAttribute('account_entity_id', $id);
        $account->setAttribute('active', 0);
        $account->update($input);
        flash('Client Updated!');
        return redirect('/cabinet/account-client');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account = AccountClient::findOrFail($id);
        $account->delete();
        flash('Client Deleted!');
        return redirect('/cabinet/account-client');
    }
}
