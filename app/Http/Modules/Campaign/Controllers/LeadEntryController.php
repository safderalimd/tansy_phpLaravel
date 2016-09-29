<?php

namespace App\Http\Modules\Campaign\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Campaign\Models\LeadEntry;
use Excel;

class LeadEntryController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . LeadEntry::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lead = new LeadEntry($request->input());
        return view('modules.campaign.LeadEntry.list', compact('lead'));
    }

    public function spreadsheet(Request $request)
    {
        // save the uploaded file
        $file = $request->file('attachment');
        $newName = time().uniqid().'.'.$file->clientExtension();
        $savedFile = $file->move(storage_path('uploads/'.domain().'/lead-entry'), $newName);

        // parse the excel
        $leads = [];
        $rows = Excel::load($savedFile->getRealPath())->get()->first();
        foreach ($rows as $row) {
            $lead = [];

            $lead['first_name'] = $row->get('First Name');
            $lead['last_name'] = $row->get('Last Name');
            $lead['mobile'] = $row->get('Mobile');
            $lead['email'] = $row->get('Email');

            $leads[] = $lead;
        }

        // delete the uploaded file
        unlink($savedFile->getRealPath());

        $lead = new LeadEntry($request->input());
        return view('modules.campaign.LeadEntry.list', compact('lead', 'leads'));
    }

    /**
     * Save the specified resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lead = new LeadEntry($request->input());
        $lead->save();
        flash('Lead Entry Updated!');
        return redirect('/cabinet/lead---quick-entry'.query_string());
    }
}
