@extends('layout.cabinet')

@section('title', 'Payment Adjustment')

@section('content')

        <div class="panel-group sch_class">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th-list"></i>
                    <h3>Payment Adjustment</h3>
                </div>
                <div class="panel-body">

                    @include('commons.errors')

                   <table class="table table-striped table-bordered table-hover" data-datatable>
                    <thead>
                        <tr>
                            <th>Account <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Product <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Schedule Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Frequency Desc. <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Amount Due <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Adjustment Amount <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

            @foreach($rows as $row)
            <tr>
                <td>{{$row['account_name']}}</td>
                <td>{{$row['product_name']}}</td>
                <td>{{$row['schedule_name']}}</td>
                <td>-</td>
                <td>{{$row['due_amount']}}</td>
                <td>{{$row['adjustment_amount']}}</td>
                <td>
                    <a class="btn btn-default" href="{{url("/cabinet/payment-adjustment/edit/{$row['product_entity_id']}")}}" title="Edit">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>
                    <a class="btn btn-default formConfirm" href="{{url("/cabinet/payment-adjustment/delete/{$row['product_entity_id']}")}}"
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
