@extends('layout.cabinet')

@section('title', 'Mark Sheet')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th"></i>
                    <h3>Mark Sheet{!! form_label() !!}</h3>
                </div>

                <div class="panel-body edit_form_wrapper">
                    <section class="form_panel">

                    @include('commons.errors')

                    <form class="form-horizontal" action="{{ form_action() }}" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="product">Product Name</label>
                            <div class="col-md-8">
                                <input id="product" class="form-control" type="text" name="product_name" value="{{ v('product_name') }}" placeholder="Product Name">
                            </div>
                        </div>

                        @include('commons.select', [
                            'label'   => 'Product Type' ,
                            'name'    => 'product_type_entity_id',
                            'options' => $product->productTypes(),
                            'keyId'   => 'product_type_entity_id',
                            'keyName' => 'product_type',
                        ])

                        @include('commons.select', [
                            'label'   => 'Facility Type' ,
                            'name'    => 'facility_ids',
                            'options' => $product->facilities(),
                            'keyId'   => 'facility_entity_id',
                            'keyName' => 'facility_name',
                        ])

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="unit-rate">Unit Rate</label>
                            <div class="col-md-8">
                                <input id="unit-rate" class="form-control" type="text" name="unit_rate" value="{{ v('unit_rate') }}" placeholder="Unit Rate">
                            </div>
                         </div>

                        <div class="row">
                           <div class="col-md-12 text-center grid_footer">
                                <button class="btn btn-primary grid_btn" type="submit">Save</button>
                                <a href="{{ url("/cabinet/product")}}" class="btn btn-default cancle_btn">Cancel</a>
                            </div>
                        </div>
                    </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
