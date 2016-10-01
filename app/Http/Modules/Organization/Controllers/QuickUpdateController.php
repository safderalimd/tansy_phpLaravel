<?php

namespace App\Http\Modules\Organization\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Organization\Models\QuickUpdate;

class QuickUpdateController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . QuickUpdate::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $update = new QuickUpdate($request->input());
        $update->loadData();
        return view('modules.organization.QuickUpdate.list', compact('update'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $update = new QuickUpdate($request->input());
        $update->setFilters();
        $update->update();
        flash('Rows Updated!');
        return redirect('/cabinet/account---quick-update'.query_string());
    }
}
