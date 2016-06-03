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
        $product = new Product;
        return view('modules.product.Product.list', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = new Product;
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
        $product = new Product;
        $product->setAttribute('active', 0);

        if ($product->save($request->input())) {
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
        $product = new Product;
        $product->setAttribute('product_entity_id', $id);
        $product->setAttribute('active', 0);

        if ($product->update($request->input())) {
            return redirect('/cabinet/product');
        }

        return redirect(url('/cabinet/product/edit', compact('id')))
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
