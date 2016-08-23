<?php

namespace App\Http\Modules\Communication\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Communication\Models\Inbox;
use App\Http\Modules\Communication\Requests\ProductFormRequest;

class InboxController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . Inbox::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inbox = new Inbox($request->input());
        $inbox->loadData();

        if ($inbox->isFirstPage()) {
            return view('modules.communication.Inbox.list', compact('inbox'));

        } else {
            return view('modules.communication.Inbox.messages', compact('inbox'));
        }
    }

    public function detail(Request $request)
    {
        $inbox = new Inbox($request->input());
        return view('modules.communication.Inbox.detail', compact('inbox'));
    }

    public function new(Request $request)
    {
        $inbox = new Inbox;
        return view('modules.communication.Inbox.new', compact('inbox'));
    }

    public function send(Request $request)
    {
        $inbox = new Inbox($request->input());
        $inbox->send();
        flash('Message Sent!');
        return redirect('/cabinet/inbox');
    }

    public function delete(Request $request)
    {
        $inbox = new Inbox($request->input());
        $inbox->deleteMessage();
        flash('Messages Deleted!');
        return redirect('/cabinet/inbox');
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     $product = new Inbox;
    //     return view('modules.product.Inbox.form', compact('product'));
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param ProductFormRequest $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(ProductFormRequest $request)
    // {
    //     $product = new Product;
    //     $product->setAttribute('active', 0);
    //     $product->save($request->input());
    //     flash('Product Added!');
    //     return redirect('/cabinet/product');
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
    //     $product->loadData();
    //     return view('modules.product.Product.form', compact('product'));
    // }

    // *
    //  * Update the specified resource in storage.
    //  *
    //  * @param ProductFormRequest $request
    //  * @param  int $id
    //  * @return \Illuminate\Http\Response

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
