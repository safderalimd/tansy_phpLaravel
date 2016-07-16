<?php

namespace App\Http\Modules\System\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\System\Models\GridPermission;
use App\Http\Modules\System\Requests\GridPermissionFormRequest;
use Illuminate\Http\Request;

class GridPermissionController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . GridPermission::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $grid = new GridPermission($request->input());
        return view('modules.system.GridPermission.list', compact('grid'));
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param ProductFormRequest $request
    //  * @param  int $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(ProductFormRequest $request, $id)
    // {
    //     $product = new Product;
    //     $product->setAttribute('product_entity_id', $id);
    //     $product->setAttribute('active', 0);
    //     $product->update($request->input());
    //     flash('Product Updated!');
    //     return redirect('/cabinet/product');
    // }
}
