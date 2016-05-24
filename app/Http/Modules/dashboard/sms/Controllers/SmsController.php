<?php

namespace App\Http\Modules\dashboard\sms\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\dashboard\sms\Models\Sms;

class SmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sms = new Sms;
        $sms->loadData();
        return view('dashboard.sms.Sms.list', compact('sms'));
    }
}
