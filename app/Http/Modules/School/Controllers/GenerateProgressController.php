<?php

namespace App\Http\Modules\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\School\Models\GenerateProgress;
use App\Http\Modules\School\Requests\GenerateProgressFormRequest;

class GenerateProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $examId = $request->input('eid');
        $progress = new GenerateProgress;
        $progress->setExamId($examId);
        return view('modules.school.GenerateProgress.list', compact('progress', 'examId'));
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
        return redirect('/cabinet/generate-progress');
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
        return redirect('/cabinet/generate-progress');
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
        return redirect('/cabinet/generate-progress');
    }
}
