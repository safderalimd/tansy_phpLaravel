<?php

namespace App\Http\Modules\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\School\Models\GenerateProgress;
use App\Http\Modules\School\Requests\GenerateProgressFormRequest;

class GenerateProgressController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . GenerateProgress::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $progress = new GenerateProgress($request->input());
        return view('modules.school.GenerateProgress.list', compact('progress'));
    }

    /**
     * Generate progress for all classes.
     *
     * @param GenerateProgressFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function generateAll(GenerateProgressFormRequest $request)
    {
        $progress = new GenerateProgress($request->input());
        $progress->setAttribute('class_entity_id', null);
        $progress->generate();
        flash('Progress Generated!');
        return redirect_back();
    }

    /**
     * Generate progress.
     *
     * @param GenerateProgressFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function generate(GenerateProgressFormRequest $request)
    {
        $progress = new GenerateProgress($request->input());
        $progress->generate();
        flash('Progress Generated!');
        return redirect('/cabinet/generate-progress?eid='.$request->input('eid'));
    }

    /**
     * Regenerate progress.
     *
     * @param GenerateProgressFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function regenerate(GenerateProgressFormRequest $request)
    {
        $progress = new GenerateProgress($request->input());
        $progress->generate();
        flash('Progress Regenerated!');
        return redirect('/cabinet/generate-progress?eid='.$request->input('eid'));
    }
}
