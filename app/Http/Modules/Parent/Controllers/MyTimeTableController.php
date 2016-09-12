<?php

namespace App\Http\Modules\Parent\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Parent\Models\MyTimeTable;

class MyTimeTableController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . MyTimeTable::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (is_null($request->input('day'))) {
            return redirect('/cabinet/my-time-table?day='.strtotime(date('Y-m-j')));
        }

        $inbox = new MyTimeTable($request->input());
        $inbox->loadData();
        return view('modules.parent.MyTimeTable.list', compact('inbox'));
    }
}
