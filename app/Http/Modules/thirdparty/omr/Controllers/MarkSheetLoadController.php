<?php

namespace App\Http\Modules\thirdparty\omr\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\thirdparty\omr\Models\MarkSheetLoad;
use App\Http\Modules\thirdparty\omr\Requests\MarkSheetLoadFormRequest;

class MarkSheetLoadController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . MarkSheetLoad::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $markSheet = new MarkSheetLoad;
        return view('thirdparty.omr.school.MarkSheetLoad.list', compact('markSheet'));
    }
}
