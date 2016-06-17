<?php

namespace App\Http\Modules\Organization\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Organization\Models\AccountAgent;
use App\Http\Modules\Organization\Requests\AccountAgentFormRequest;

class AccountAgentController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:'.AccountAgent::screenId());
    }

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
        $input = $request->input();
        $input['city_area'] = $request->input('city_area_new');

        $account = new AccountAgent;
        $account->setAttribute('active', 0);
        $account->setAttribute('login_active', 0);

        $account->fill($input);

        $group = $account->securityGroupForAgent();
        if (isset($group[0]['security_group_entity_id'])) {
            $account->setAttribute('security_group_entity_id', $group[0]['security_group_entity_id']);
        }

        $account->save();
        flash('Agent Created!');
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
        $input = $request->input();
        $input['city_area'] = $request->input('city_area_new');

        $account = new AccountAgent;
        $account->setAttribute('account_entity_id', $id);
        $account->setAttribute('active', 0);
        $account->setAttribute('login_active', 0);

        $account->fill($input);

        $group = $account->securityGroupForAgent();
        if (isset($group[0]['security_group_entity_id'])) {
            $account->setAttribute('security_group_entity_id', $group[0]['security_group_entity_id']);
        }

        $account->update();
        flash('Agent Updated!');
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
        flash('Agent Deleted!');
        return redirect('/cabinet/account-agent');
    }
}
