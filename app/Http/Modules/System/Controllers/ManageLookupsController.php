<?php

namespace App\Http\Modules\System\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\System\Models\ManageLookups;
use App\Http\Modules\System\Requests\ManageLookupsFormRequest;
use Illuminate\Http\Request;

class ManageLookupsController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . ManageLookups::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lookups = new ManageLookups($request->input());
        return view('modules.system.ManageLookups.list', compact('lookups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $lookups = new ManageLookups($request->input());
        $lookups->updateManageLookups();
        flash('Grid Setup Updated!');
        return redirect_back();
    }
}
