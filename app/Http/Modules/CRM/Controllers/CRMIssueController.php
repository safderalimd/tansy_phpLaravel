<?php

namespace App\Http\Modules\CRM\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\CRM\Models\CRMIssue;

class CRMIssueController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . CRMIssue::screenId());

        // $this->middleware('screen:' . CRMIssue::screenId(), ['only' => [
        //     'index',
        //     'create',
        //     'store',
        // ]]);

        // $this->middleware('screen:' . CRMVisitDetail::screenId(), ['only' => [
        //     'detail',
        // ]]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $issue = new CRMIssue;
        return view('modules.crm.CRMIssue.form', compact('issue'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $issue = new CRMIssue($request->input());
        $issue->save();
        flash('CRM Issue Added!');
        return redirect('/cabinet/crm-issue/edit/' . $issue->issue_id . query_string());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $issue = CRMIssue::findIssue($id);
        return view('modules.crm.CRMIssue.form', compact('issue'));
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
        $issue = new CRMIssue;
        $issue->setAttribute('issue_id', $id);
        $issue->update($request->input());
        flash('CRM Issue Updated!');
        return redirect('/cabinet/crm-issue'.query_string());
    }

    /**
     * Add a new comment.
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function comment(Request $request, $id)
    {
        $issue = new CRMIssue($request->input());
        $issue->setAttribute('issue_id', $id);
        $issue->saveComment();
        flash('Comment Added!');
        return redirect('/cabinet/crm-issue/edit/'.$id.query_string());
    }
}
