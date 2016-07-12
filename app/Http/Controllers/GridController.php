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
    public function __construct()
    {
        // $this->middleware(screen_id_for_current_url());
        // $this->middleware('screen:' . AccountStudent::screenId());
    }

    public function index()
    {
        $grid = new Grid;
        $columns = $grid->columns();
        return view('grid.list', compact('grid', 'columns'));
    }

}
