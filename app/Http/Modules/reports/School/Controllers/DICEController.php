<?php

namespace App\Http\Modules\reports\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\reports\School\Models\DICE;
use App\Http\FPDF\DICE\DICEPDF;
use Device;

class DICEController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . DICE::screenId());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        $export = new DICE($request->input());
        $export->setOwnerOrganizationInfo();

        if (Device::isAndroidMobile()) {
            return view('reports.school.DICE.pdf', compact('export'));
        } else {
            DICEPDF::landscape()->generate($export);
        }
    }
}
