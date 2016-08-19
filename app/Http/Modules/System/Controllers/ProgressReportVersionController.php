<?php

namespace App\Http\Modules\System\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\System\Models\ProgressReportVersion;
use Illuminate\Http\Request;

class ProgressReportVersionController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . ProgressReportVersion::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $version = new ProgressReportVersion($request->input());
        return view('modules.system.ProgressReportVersion.list', compact('version'));
    }

    public function update(Request $request)
    {
        $version = new ProgressReportVersion($request->input());
        $product->update();
        flash('Report Version Updated!');
        return redirect_back();
    }
}
