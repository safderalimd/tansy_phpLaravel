<?php

namespace App\Http\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Admin\Models\Admin;
use App\Http\Modules\Admin\Requests\AdminFormRequest;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $admin = new Admin;
        return view('modules.admin.Admin.home', compact('admin'));
    }

    public function debugReset()
    {
        // $admin = new Admin;
        // $admin->repository->debugReset();
        return view('cabinet.main');
    }
}
