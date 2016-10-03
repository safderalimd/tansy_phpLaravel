<?php

namespace App\Http\Modules\System\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\System\Models\TimeTablePeriod;
use Validator;
use Illuminate\Http\Request;

class TimeTablePeriodController extends Controller
{
    /**
     * Contains the ajax error message.
     *
     * @var array
     */
    protected $error;

    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . TimeTablePeriod::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $period = new TimeTablePeriod($request->input());
        $period->loadData();
        return view('modules.system.TimeTablePeriod.list', compact('period'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->validationFails($request)) {
            return $this->errors();
        }

        $period = new TimeTablePeriod($request->input());
        $period->save();
        return ['success' => true];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($this->validationFails($request)) {
            return $this->errors();
        }

        $period = new TimeTablePeriod($request->input());
        $period->update();
        return ['success' => true];
    }

    protected function validationFails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'period_type_id'  => 'required',
            'period_name'     => 'required',
            'start_time'      => 'required',
            'end_time'        => 'required',
            'reporting_order' => 'required|integer',
            'active'          => 'required',
        ]);

        if ($validator->fails()) {
            $this->error = $validator->errors()->first();
            return true;
        }

        return false;
    }

    protected function errors()
    {
        return ['error' => $this->error];
    }
}
