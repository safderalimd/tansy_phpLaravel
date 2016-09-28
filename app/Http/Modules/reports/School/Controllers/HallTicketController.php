<?php

namespace App\Http\Modules\reports\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\reports\School\Models\HallTicket;
use App\Http\FPDF\HallTicket\HallTicketPDF;
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
        // $imgPath = \App\Http\Photos\Photo::studentProfileImage(398);
        // list($imageWidth, $imageHeight) = getimagesize($imgPath);
        // d($imageWidth);
        // dd($imageHeight);

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
            return view('reports.school.HallTicket.pdf', compact('export'));
        } else {
            HallTicketPDF::portrait()->generate($export);
        }
    }
}
