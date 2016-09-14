<?php

namespace App\Http\Modules\dashboard\sms\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\dashboard\sms\Models\DashboardSms;

class DashboardSmsController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . DashboardSms::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sms = new DashboardSms;
        $sms->loadData();
        return view('dashboard.sms.DashboardSms.list', compact('sms'));
    }
}
