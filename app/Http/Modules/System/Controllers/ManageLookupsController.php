<?php

namespace App\Http\Modules\System\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\System\Models\ManageLookups;
use Validator;
use Illuminate\Http\Request;

class ManageLookupsController extends Controller
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
        $this->middleware('screen:' . ManageLookups::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lookups = new ManageLookups($request->input());
        $lookups->loadData();
        return view('modules.system.ManageLookups.list', compact('lookups'));
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

        $lookups = new ManageLookups($request->input());
        $lookups->save();
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

        $lookups = new ManageLookups($request->input());
        $lookups->update();
        return ['success' => true];
    }

    protected function validationFails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description'     => 'required',
            'active'          => 'required',
            'reporting_order' => 'integer',
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
