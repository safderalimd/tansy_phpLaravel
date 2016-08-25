<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ContactFormRequest;

class ContactController extends Controller
{
    public function send(ContactFormRequest $request)
    {
        dd($request->input());
        return redirect('/cabinet/product');
    }
}
