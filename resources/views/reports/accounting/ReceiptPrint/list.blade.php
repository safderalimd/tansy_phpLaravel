@extends('layout.cabinet')

@section('title', 'Receipt')

@section('content')

        <div class="panel-group sch_class">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th-list"></i>
                    <h3>Receipt</h3>
                </div>
                <div class="panel-body">

                    @include('commons.errors')

                   <table class="table table-striped table-bordered table-hover" data-datatable>
                    <thead>
                        <tr>
                            <th>Receipt Number <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Receipt Date <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Amount Paid <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

            @foreach($receipt->receiptGrid() as $item)
            <tr>
                <td>{{$item['receipt_number']}}</td>
                <td>{{$item['receipt_date']}}</td>
                <td>{{$item['receipt_amount']}}</td>
                <td>
                    <a class="btn btn-default" target="_blank" href="{{url("/cabinet/receipt-report/pdf/{$item['receipt_id']}")}}" title="Print PDF">Print PDF</a>
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
