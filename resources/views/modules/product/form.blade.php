@extends('layout.cabinet')

@section('title', 'Product')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
			    <div class="panel-heading">
                	<i class="glyphicon glyphicon-th"></i>
                	<h3>Product</h3>
					@if(Request::segment(3) == "edit")
						<label>- Update</label>
					@else
						<label>- Add New Record</label>
					@endif
                </div>

                <div class="panel-body edit_form_wrapper">

                    @include('commons.errors')

                    <form class="form-horizontal"
                          action="@if($product->isNewRecord()){{ url("/cabinet/product/create")}} @else {{url("/cabinet/product/update/{$product->getID()}")}} @endif"
                          method="POST">
                        {{ csrf_field() }}

                        <section class="form_panel">
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <div class="checkbox">
                                    <label>
                                        @if($product->isNewRecord())
                                            <input checked="checked" name="activeRow" type="checkbox" disabled readonly> Active
                                        @else
									       {!! Form::checkbox('activeRow', old('activeRow'), $product->activeRow) !!} Active
                                        @endif
                                    </label>
                                </div>
                            </div>
                        </div>

               			<div class="form-group">
                            <label class="col-md-4 control-label" for="name">Product Name</label>
                            <div class="col-md-8">
                                <input id="product" class="form-control" type="text" name="product"
                                       value="@if(!empty($product->product)){!!$product->product!!}@else{{ old('product') }}@endif"
                                       placeholder="Product Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="productType">Product Type</label>
                            <div class="col-md-8">
                                <select id="productType" class="form-control" name="productType">
                                    @foreach($product->types() as $type)
                                        @if(!empty(old('productTypes')))
                                            <option @if ($type['product_type_entity_id'] == old('productTypes')[0]) selected @endif value="{!!$type['product_type_entity_id']!!}">{!!$type['product_type']!!}</option>
                                        @else
                                            <option @if ($product->hasType($type)) selected @endif value="{!!$type['product_type_entity_id']!!}">{!!$type['product_type']!!}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="facility">Facility Type</label>
                            <div class="col-md-4">
                                <select id="facility" class="form-control" name="facilityID">
                                    @foreach($product->facilities() as $facility)
                                        @if(!empty(old('facilityID')))
                                            <option @if ($facility['facility_entity_id'] == old('facilityID')) selected @endif value="{!!$facility['facility_entity_id']!!}">{!!$facility['facility_name']!!}</option>
                                        @else
                                            <option @if ($product->hasFacility($facility)) selected @endif value="{!!$facility['facility_entity_id']!!}">{!!$facility['facility_name']!!}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="unit-rate">Unit Rate</label>
                            <div class="col-md-8">
                                <input id="unit-rate" class="form-control" type="text" name="unitRate" value="@if(!empty($product->unitRate)){!!$product->unitRate!!}@else{{ old('unitRate') }}@endif" placeholder="Unit Rate">
                            </div>
                         </div>

                        </section>
						<div class="row_footer">
                           <div class="col-md-12 text-center grid_footer">
                                <button class="btn btn-primary grid_btn" type="submit">Save</button>
                                <a href="{{ url("/cabinet/product")}}" class="btn btn-default cancle_btn">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
