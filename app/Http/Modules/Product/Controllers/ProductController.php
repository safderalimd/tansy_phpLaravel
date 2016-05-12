<?php

namespace App\Http\Modules\Product\Controllers;

use Illuminate\Http\Request;
use App\Http\Modules\Product\Models\Product;
use App\Http\Modules\Product\Requests\ProductFormRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = DB::connection('secondDB')->select(
            'SELECT  product, product_type, unit_rate, product_type_entity_id, product_entity_id
             FROM view_prd_lkp_product
             ORDER BY product DESC;'
        );

        return view('modules.product.Product.list', ['data' => $rows]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new Product();
        $productTypes = $this->getProductTypes();
        $facility = $this->getFacility();

        return view('modules.product.Product.form', compact('model', 'productTypes', 'facility'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductFormRequest|Request $request
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

    private function getProductTypes()
    {
        return DB::connection('secondDB')->select(
            'SELECT product_type_entity_id, product_type
             FROM view_prd_lkp_product_type
             ORDER BY product_type;'
        );
    }

    private function getFacility()
    {
        return DB::connection('secondDB')->select(
            'SELECT  facility_entity_id, facility_name
             FROM view_org_lkp_facility
             ORDER BY facility_name;'
        );
    }

}
