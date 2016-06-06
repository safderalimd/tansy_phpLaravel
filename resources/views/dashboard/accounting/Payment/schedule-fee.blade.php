@extends('layout.cabinet')

@section('title', 'Schedule Fee')

@section('content')

        <div class="panel-group sch_class">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th-list"></i>
                    <h3>Schedule Fee</h3>
                </div>
                <div class="panel-body">

                    @include('commons.errors')

    <table class="table table-striped table-bordered table-hover" data-datatable>
        <thead>
            <tr>
                <th>Schedule Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                <th>Product Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                <th>Scheduled For <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                <th>Frequency <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                <th>Start Date <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                <th>End Date <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                <th>Amount <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
            </tr>
        </thead>
        <tbody>
            @foreach($payment->scheduleDetail() as $item)
            <tr>
                <td>{{$item['schedule_name']}}</td>
                <td>{{$item['product_name']}}</td>
                <td>{{$item['scheduled_for']}}</td>
                <td>{{$item['frequency']}}</td>
                <td>{{style_date($item['start_date'])}}</td>
                <td>{{style_date($item['end_date'])}}</td>
                <td>&#x20b9; {{amount($item['amount'])}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

                    @include('commons.modal')

                </div>
            </div>
        </div>

@endsection
