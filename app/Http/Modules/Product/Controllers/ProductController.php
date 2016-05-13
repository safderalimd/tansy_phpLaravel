<?php

namespace App\Http\Modules\Product\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Product\Models\Product;
use App\Http\Modules\Product\Requests\ProductFormRequest;
use App\Http\Modules\Product\ProductRepository;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductRepository $repo)
    {
        $products = $repo->getAllProducts();
        return view('modules.product.product.list', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ProductRepository $repo)
    {
        $model = new Product();
        $productTypes = $repo->getProductTypes();
        $facilities = $repo->getFacilities();

        return view('modules.product.product.form', compact('model', 'productTypes', 'facilities'));
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
        $model = new Product($params);

        if ($model->save()) {
            return redirect(url('/cabinet/product'));
        }

        return redirect('/cabinet/product/create')->withErrors($model->getErrors());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ProductRepository $repo
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductRepository $repo, $id)
    {
        $model = Product::findOrFail($id);
        $productTypes = $repo->getProductTypes();
        $facilities = $repo->getFacilities();

        return view('modules.product.product.form', compact('model', 'productTypes', 'facilities'));
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

        $model = new Product($params);
        if ($model->save()) {
            return redirect(url('/cabinet/product'));
        }

        return redirect(url('/cabinet/product/edit', ['id' => $model->getID()]))
            ->withErrors($model->getErrors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Product::findOrFail($id);

        if ($model->delete()) {
            return redirect('/cabinet/product');
        }

        return redirect('/cabinet/product')->withErrors($model->getErrors());
    }
}
