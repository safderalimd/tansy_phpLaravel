@extends('layout.cabinet')

@section('title', 'Products')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
    	<div class="panel-heading">
        	<i class="glyphicon glyphicon-th-list"></i>
        	<h3>Product</h3>
        	<a href="{{url('/cabinet/product/create/')}}" class="btn pull-right btn-default">Add new record</a>
        </div>
        <div class="panel-body">

            @include('commons.errors')

           <table class="table table-striped table-bordered table-hover" data-datatable>
            <thead>
                <tr>
                    <th>Product Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    <th>Product Type <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    <th>Active <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
    @foreach($product->products() as $item)
    <tr>
        <td>{{$item['product']}}</td>
        <td>{{$item['product_type']}}</td>
        <td>
            @if ($item['active'])
                <strong>Active</strong>
            @else
                Inactive
            @endif
        </td>
        <td>
            <a class="btn btn-default" href="{{url("/cabinet/product/edit/{$item['product_entity_id']}")}}" title="Edit">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
            </a>
            <a class="btn btn-default formConfirm" href="{{url("/cabinet/product/delete/{$item['product_entity_id']}")}}"
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
