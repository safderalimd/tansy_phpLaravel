<?php

namespace App\Http\Modules\thirdparty\sms\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Grid;
use Carbon\Carbon;

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
            $start = Carbon::now()->subDays(7)->toDateString();
            $end = Carbon::now()->addDays(1)->toDateString();
            return redirect('/cabinet/sms-batch?f1='.$start.'&f2='.$end);
        }

        $grid = new Grid('/' . $request->path());
        $grid->fill($request->input());
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
