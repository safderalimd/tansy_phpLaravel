<?php

namespace App\Http\Modules\System\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\System\Models\GridSetup;
use App\Http\Modules\System\Requests\GridSetupFormRequest;
use Illuminate\Http\Request;

class GridSetupController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . GridSetup::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $grid = new GridSetup($request->input());
        return view('modules.system.GridSetup.list', compact('grid'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $grid = new GridSetup($request->input());
        $grid->updatePermissions();
        flash('Grid Permission Updated!');
        return redirect_back();
    }
}
