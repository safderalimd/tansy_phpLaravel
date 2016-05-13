@extends('layout.cabinet')

@section('content')

        <div class="panel-group sch_class">
            <div class="panel panel-primary">
            	<div class="panel-heading">
                	<i class="glyphicon glyphicon-th-list"></i>
                	<h3>Product</h3>
                	<a href="{!!url('/cabinet/product/create/')!!}" class="btn pull-right btn-default">Add new record</a>
                </div>
                <div class="panel-body">
                   <table class="table table-striped table-bordered table-hover" data-datatable>
                    <thead>
                        <tr>
                            <th>Product Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Product Type <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{$product['product']}}</td>
                <td>{{$product['product_type']}}</td>
                <td>
                    @if ($product['active'])
                        <strong>Active</strong>
                    @else
                        Inactive
                    @endif
                </td>
                <td>
                    <a class="btn btn-default" href="{{url("/cabinet/product/edit/{$product['product_entity_id']}")}}" title="Edit">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>
                    <a class="btn btn-default formConfirm" href="{{url("/cabinet/product/delete/{$product['product_entity_id']}")}}"
                       title="Delete"
                       data-title="Delete Product"
                       data-message="Are you sure to delete the selected record?"
                    >
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </a>
                </td>
            </tr>
            @endforeach
                        </tbody>
                    </table>

    			    @include('commons.modal')

                </div>
            </div>
        </div>

@endsection
