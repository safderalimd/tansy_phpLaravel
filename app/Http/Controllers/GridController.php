<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Models\Grid;

class GridController extends Controller
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

    public function index(Request $request)
    {
        $grid = new Grid('/' . $request->path());
        $grid->loadData();
        $columns = $grid->columns();
        $buttons = $grid->buttons();
        return view('grid.list', compact('grid', 'columns', 'buttons'));
    }

}
