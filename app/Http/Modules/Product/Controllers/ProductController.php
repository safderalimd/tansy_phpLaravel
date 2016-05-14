<?php

namespace App\Http\Modules\Product\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Product\Models\Product;
use App\Http\Modules\Product\Requests\ProductFormRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('modules.product.Product.list', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = new Product();
        return view('modules.product.Product.form', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductFormRequest $request)
    {
        $params = $request->input();
        $product = new Product($params);

        if ($product->save()) {
            return redirect('/cabinet/product');
        }

        return redirect('/cabinet/product/create')->withErrors($product->getErrors());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('modules.product.Product.form', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductFormRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductFormRequest $request, $id)
    {
        $params = $request->input();
        $params['product_entity_id'] = $id;

        $product = new Product($params);
        if ($product->save()) {
            return redirect('/cabinet/product');
        }

        return redirect(url('/cabinet/product/edit', ['id' => $product->getID()]))
            ->withErrors($product->getErrors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->delete()) {
            return redirect('/cabinet/product');
        }

        return redirect('/cabinet/product')->withErrors($product->getErrors());
    }
}
