<?php

namespace App\Http\Modules\System\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\System\Models\GridPermission;
use App\Http\Modules\System\Requests\GridPermissionFormRequest;
use Illuminate\Http\Request;

class GridPermissionController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . GridPermission::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $grid = new GridPermission($request->input());
        return view('modules.system.GridPermission.list', compact('grid'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $grid = new GridPermission($request->input());
        $grid->updatePermissions();
        flash('Grid Permission Updated!');
        return redirect_back();
    }
}
