<?php

namespace App\Http\Modules\Organization\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Organization\Models\AccountStudent;
use App\Http\Modules\Organization\Requests\AccountStudentFormRequest;

class AccountStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account = new AccountStudent;
        return view('modules.organization.AccountStudent.list', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $account = AccountStudent::findOrFail($id);
        return view('modules.organization.AccountStudent.form', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AccountStudentFormRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AccountStudentFormRequest $request, $id)
    {
        $account = new AccountStudent($request->input());
        $account->setAttribute('student_entity_id', $id);
        if (empty($request->input('active'))) {
            $account->setActiveToFalse();
        }

        $account->update();
        return redirect('/cabinet/student-account');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account = AccountStudent::findOrFail($id);
        $account->delete();
        return redirect('/cabinet/student-account');
    }
}
