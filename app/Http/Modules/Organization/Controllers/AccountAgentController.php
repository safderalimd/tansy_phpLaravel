<?php

namespace App\Http\Modules\Organization\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Organization\Models\AccountAgent;
use App\Http\Modules\Organization\Requests\AccountAgentFormRequest;

class AccountAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account = new AccountAgent;
        return view('modules.organization.AccountAgent.list', compact('account'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $account = new AccountAgent;
        return view('modules.organization.AccountAgent.form', compact('account'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AccountAgentFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountAgentFormRequest $request)
    {
        $account = new AccountAgent;
        $account->setAttribute('active', 0);
        $account->setAttribute('user_account_active', 0);
        $account->save($request->input());
        return redirect('/cabinet/account-agent');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $account = AccountAgent::findOrFail($id);
        $account->loadData();
        return view('modules.organization.AccountAgent.form', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AccountAgentFormRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AccountAgentFormRequest $request, $id)
    {
        $account = new AccountAgent;
        $account->setAttribute('account_entity_id', $id);
        $account->setAttribute('active', 0);
        $account->setAttribute('user_account_active', 0);
        $account->update($request->input());
        return redirect('/cabinet/account-agent');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account = AccountAgent::findOrFail($id);
        $account->delete();
        return redirect('/cabinet/account-agent');
    }
}
