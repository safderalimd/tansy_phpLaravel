<?php

namespace App\Http\Modules\dashboard\accounting\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\dashboard\accounting\Models\Payment;
use App\Http\Modules\dashboard\accounting\Requests\PaymentFormRequest;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment = new Payment;
        return view('dashboard.accounting.Payment.list', compact('payment'));
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     $product = new Product;
    //     return view('modules.product.Product.form', compact('product'));
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param ProductFormRequest $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(ProductFormRequest $request)
    // {
    //     $product = new Product($request->input());

    //     if ($product->save()) {
    //         return redirect('/cabinet/product');
    //     }

    //     return redirect('/cabinet/product/create')->withErrors($product->getErrors());
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     $product = Product::findOrFail($id);
    //     return view('modules.product.Product.form', compact('product'));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param ProductFormRequest $request
    //  * @param  int $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(ProductFormRequest $request, $id)
    // {
    //     $product = Product::findOrFail($id);

    //     if ($product->update($request->input())) {
    //         return redirect('/cabinet/product');
    //     }

    //     return redirect(url('/cabinet/product/edit', compact('id')))
    //         ->withErrors($product->getErrors());
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     $product = Product::findOrFail($id);

    //     if ($product->delete()) {
    //         return redirect('/cabinet/product');
    //     }

    //     return redirect('/cabinet/product')->withErrors($product->getErrors());
    // }
}
