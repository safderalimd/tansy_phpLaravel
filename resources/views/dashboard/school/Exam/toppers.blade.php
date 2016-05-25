@extends('layout.cabinet')

@section('title', 'Toppers')

@section('content')

        <div class="panel-group sch_class">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th-list"></i>
                    <h3>Toppers</h3>
                </div>
                <div class="panel-body">

                    @include('commons.errors')

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
                    @foreach($exam->overallGrade() as $item)
                    <tr>
                        <td>{{$item['product']}}</td>
                        <td>{{$item['product_type']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

                    @include('commons.modal')

                </div>
            </div>
        </div>

@endsection
