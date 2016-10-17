<?php

namespace App\Http\Modules\reports\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\reports\School\Models\HallTicket;
use App\Http\FPDF\HallTicket\HallTicketPDF;
use App\Http\FPDF\HallTicket\HallTicketPDFV2;
use Device;

class HallTicketController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . HallTicket::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $report = new HallTicket;
        return view('reports.school.HallTicket.list', compact('report'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        $export = new HallTicket($request->input());
        $export->loadPdfData();

        if (Device::isAndroidMobile()) {
            if ($export->hallTicketVersion() == 'V-002') {
                return view('reports.school.HallTicket.pdf-v2', compact('export'));
            } else {
                return view('reports.school.HallTicket.pdf', compact('export'));                
            }
        } else {
            if ($export->hallTicketVersion() == 'V-002') {
                HallTicketPDFV2::portrait()->generate($export);
            } else {
                HallTicketPDF::portrait()->generate($export);
            }
        }
    }
}
