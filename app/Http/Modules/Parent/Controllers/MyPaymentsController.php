<?php

namespace App\Http\Modules\Parent\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Parent\Models\MyPayments;

class MyPaymentsController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . MyPayments::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $history = new MyPayments;
        d($history->grid());
        dd($history);
        return view('modules.parent.MyPayments.list', compact('history'));
    }
}
