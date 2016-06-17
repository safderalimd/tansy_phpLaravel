<?php

namespace App\Http\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Admin\Models\Admin;
use App\Http\Modules\Admin\Requests\AdminFormRequest;

class AdminController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:'.Admin::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $admin = new Admin;
        $admin->loadData();

        if ($admin->displayType == 'SQUARE BOX 4') {
            return view('modules.admin.Admin.sysadmin', compact('admin'));

        } elseif ($admin->displayType == 'SQUARE BOX 2') {
            return view('modules.admin.Admin.employee', compact('admin'));

        } elseif ($admin->displayType == 'URL') {
            return view('modules.admin.Admin.parent', compact('admin'));

        } elseif ($admin->displayType == 'RE-DIRECT') {
            $screenId = $admin->boxRawValue(0);
            $menuInfo = session('dbMenuInfo');
            foreach ($menuInfo as $row) {
                if ($row['screen_id'] == $screenId) {
                    $name = strtolower($row['screen_name']);
                    $name = str_replace(' ', '-', $name);
                    return redirect('/cabinet/' . $name);
                }
            }
        }

        return redirect('/');
    }

    public function debugReset()
    {
        $admin = new Admin;
        $admin->repository->debugReset($admin);
        return "Reset sproc was called.";
    }
}
