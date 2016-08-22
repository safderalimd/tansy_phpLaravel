<?php

namespace App\Http\Modules\Parent\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Parent\Models\MySMSHistory;

class MySMSHistoryController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . MySMSHistory::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $history = new MySMSHistory;
        d($history->grid());
        dd($history);
        return view('modules.parent.MySMSHistory.list', compact('history'));
    }
}
