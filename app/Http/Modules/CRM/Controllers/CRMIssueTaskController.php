<?php

namespace App\Http\Modules\CRM\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\CRM\Models\CRMIssueTask;

class CRMIssueTaskController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . CRMIssueTask::screenId());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $issue = new CRMIssueTask;
        return view('modules.crm.CRMIssueTask.form', compact('issue'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $issue = new CRMIssueTask($request->input());
        $issue->save();
        flash('CRM Issue Added!');
        return redirect('/cabinet/crm-issue-task/edit/' . $issue->issue_id . query_string());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $issue = CRMIssueTask::findIssue($id);
        return view('modules.crm.CRMIssueTask.form', compact('issue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $issue = new CRMIssueTask;
        $issue->setAttribute('issue_id', $id);
        $issue->update($request->input());
        flash('CRM Issue Updated!');
        return redirect('/cabinet/crm-issue-task'.query_string());
    }
}
