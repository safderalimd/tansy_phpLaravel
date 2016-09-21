<?php

namespace App\Http\Modules\thirdparty\sms\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Grid;

class SmsBatchController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $grid = new Grid('/' . $request->path());
        $this->middleware('screen:' . $grid->getScreenId());
    }

    public function smsBatch(Request $request)
    {
        if (is_null($request->input('f1')) && is_null($request->input('f2'))) {
            $date = current_system_date();
            return redirect('/cabinet/sms-batch?f1='.$date.'&f2='.$date);
        }

        $grid = new Grid('/' . $request->path());
        $grid->loadData();
        return view('grid.list', compact('grid'));
    }

    public function smsBatchDetails(Request $request)
    {
        $grid = new Grid('/' . $request->path());
        $grid->setAttribute('f1', $request->input('id'));
        $grid->loadData();
        return view('grid.list', compact('grid'));
    }
}
