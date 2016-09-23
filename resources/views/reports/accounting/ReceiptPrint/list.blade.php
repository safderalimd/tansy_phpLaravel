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
                <td>{{style_date($item['receipt_date'])}}</td>
                <td>&#x20b9; {{amount($item['receipt_amount'])}}</td>
                <td>
                    @if ($receipt->version() == 'V-0002')
                        <a class="btn btn-default" target="_blank" href="{{url("/cabinet/pdf---receipt-v2/pdf?id={$item['receipt_id']}")}}" title="Print PDF">Print PDF</a>
                    @else
                        <a class="btn btn-default" target="_blank" href="{{url("/cabinet/pdf---receipt-v1/pdf?id={$item['receipt_id']}")}}" title="Print PDF">Print PDF</a>
                    @endif
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
