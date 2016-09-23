<?php

namespace App\Http\Modules\CRM\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\CRM\Models\CRMIssueTask;
use App\Http\Models\Grid;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $grid = new Grid('/' . $request->path());
        $grid->setAttribute('f1', $request->input('id'));
        $grid->loadData();

        $options = [
            'afterGridInclude' => 'modules.crm.CRMIssueTask.after-grid-include',
        ];

        return view('grid.list', compact('grid', 'options'));
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
        flash('Task Added!');
        return redirect('/cabinet/crm-issue-task'.query_string());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $issue = CRMIssueTask::find($id);
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
        $issue = new CRMIssueTask($request->input());
        $issue->setAttribute('task_id', $id);
        $issue->update();
        flash('Task Updated!');
        return redirect('/cabinet/crm-issue-task'.query_string());
    }
}
