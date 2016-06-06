@extends('layout.cabinet')

@section('title', 'Fee Due')

@section('content')

        <div class="panel-group sch_class">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th-list"></i>
                    <h3>Fee Due</h3>
                </div>
                <div class="panel-body">

                    @include('commons.errors')

            <table class="table table-striped table-bordered table-hover" data-datatable>
                <thead>
                    <tr>
                        <th>Product Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Account Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Schedule Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Current Schedule <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Due Start Date <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Due End Date <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Total Amount <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Total Credit Amount <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Paid Amount <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Adjustment Amount <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Due Amount <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($student->feeDueDetails() as $item)
                    <tr>
                        <td>{{$item['product_name']}}</td>
                        <td>{{$item['account_name']}}</td>
                        <td>{{$item['schedule_name']}}</td>
                        <td>{{$item['current_schedule_name']}}</td>
                        <td>{{$item['due_start_date']}}</td>
                        <td>{{$item['due_end_date']}}</td>
                        <td>&#x20b9; {{amount($item['total_amount'])}}</td>
                        <td>&#x20b9; {{amount($item['total_credit_amount'])}}</td>
                        <td>&#x20b9; {{amount($item['paid_amount'])}}</td>
                        <td>&#x20b9; {{amount($item['adjustment_amount'])}}</td>
                        <td>&#x20b9; {{amount($item['due_amount'])}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

                    @include('commons.modal')

                </div>
            </div>
        </div>

@endsection
