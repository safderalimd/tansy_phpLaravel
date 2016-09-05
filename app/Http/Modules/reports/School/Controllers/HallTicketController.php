<?php

namespace App\Http\Modules\reports\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\reports\School\Models\HallTicket;
use App\Http\PdfGenerator\Pdf;

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
        $ticket = new HallTicket;
        return view('reports.school.HallTicket.list', compact('ticket'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function report(HallTicket $request)
    {
        $export = new StudentDetail($request->input());

        $view = view('grid.PDF.pdf', compact('grid', 'options'));
        return Pdf::render($view);
    }
}