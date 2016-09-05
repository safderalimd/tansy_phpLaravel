<?php

namespace App\Http\Modules\Teacher\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Teacher\Models\TeacherSubjectMap;

class TeacherSubjectMapController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . TeacherSubjectMap::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $teacher = new TeacherSubjectMap($request->input());
        return view('modules.teacher.TeacherSubjectMap.list', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $product = new Product;
        $product->setAttribute('product_entity_id', $id);
        $product->setAttribute('active', 0);
        $product->update($request->input());
        flash('Product Updated!');
        return redirect('/cabinet/product');
    }
}
