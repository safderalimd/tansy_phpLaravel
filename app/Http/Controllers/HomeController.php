<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class HomeController extends Controller
{
    public function index()
    {
        return view('tansycloud');
    }

    public function databaseError()
    {
        return view('errors.db-error');
    }
}
