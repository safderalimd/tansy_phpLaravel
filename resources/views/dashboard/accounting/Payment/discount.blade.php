@extends('layout.cabinet')

@section('title', 'Discount')

@section('content')

        <div class="panel-group sch_class">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th-list"></i>
                    <h3>Discount</h3>
                </div>
                <div class="panel-body">

                    @include('commons.errors')

    <table class="table table-striped table-bordered table-hover" data-datatable>
        <thead>
            <tr>
                <th>Account Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                <th>Schedule Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                <th>Credit Date <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                <th>Adjustment Amount <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
            </tr>
        </thead>
        <tbody>
            @foreach($payment->detailCurrentFiscal() as $item)
            <tr>
                <td>{{$item['account_name']}}</td>
                <td>{{$item['schedule_name']}}</td>
                <td>{{style_date($item['credit_date'])}}</td>
                <td>&#x20b9; {{amount($item['adjustment_amount'])}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

                    @include('commons.modal')

                </div>
            </div>
        </div>

@endsection
