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

        if ($progress->generate()) {
            return redirect('/cabinet/generate-progress');
        }

        return redirect('/cabinet/generate-progress')->withErrors($progress->getErrors());
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

        if ($progress->generate()) {
            return redirect('/cabinet/generate-progress');
        }

        return redirect('/cabinet/generate-progress')->withErrors($progress->getErrors());
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

        if ($progress->generate()) {
            return redirect('/cabinet/generate-progress');
        }

        return redirect('/cabinet/generate-progress')->withErrors($progress->getErrors());
    }

}
