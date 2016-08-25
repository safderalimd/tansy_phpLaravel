<?php

namespace App\Http\Modules\School\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\School\Models\ProgressGradeSetup;
use Validator;
use Illuminate\Http\Request;
use Exception;

class ProgressGradeSetupController extends Controller
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
        $this->middleware('screen:' . ProgressGradeSetup::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $progress = new ProgressGradeSetup($request->input());
        $progress->loadData();
        return view('modules.school.ProgressGradeSetup.list', compact('progress'));
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

        try {
            $progress = new ProgressGradeSetup($request->input());
            $progress->save();
            return ['success' => true];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
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

        try {
            $progress = new ProgressGradeSetup($request->input());
            $progress->update();
            return ['success' => true];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $progress = new ProgressGradeSetup($request->input());
            $progress->delete();
            return ['success' => true];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    protected function validationFails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_percent' => 'required|numeric',
            'end_percent'   => 'required|numeric',
            'grade'         => 'required',
            'gpa'           => 'required|numeric',
            'pass_fail'     => 'required',
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
