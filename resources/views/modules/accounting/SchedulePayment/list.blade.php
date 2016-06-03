@extends('layout.cabinet')

@section('title', 'Schedule Payment')

@section('content')

        <div class="panel-group sch_class">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th-list"></i>
                    <h3>Schedule Payment</h3>
                    <a href="{!!url('/cabinet/schedule-payment/create/')!!}" class="btn pull-right btn-default">Add new record</a>
                </div>
                <div class="panel-body">

                    @include('commons.errors')

                   <table class="table table-striped table-bordered table-hover" data-datatable>
                    <thead>
                        <tr>
                            <th>Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Product <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Frequency Type <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Start Date <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>End Date <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Amount (<i class="fa fa-inr"></i>) <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
            @foreach($payment->scheduleGrid() as $item)
            <tr>
                <td>{{$item['schedule_name']}}</td>
                <td>{{$item['product_name']}}</td>
                <td>{{$item['frequency']}}</td>
                <td>{{style_date($item['start_date'])}}</td>
                <td>{{style_date($item['end_date'])}}</td>
                <td>&#x20b9; {{amount($item['amount'])}}</td>
                <td>
                    <a class="btn btn-default" href="{{url("/cabinet/schedule-payment/edit/{$item['schedule_entity_id']}")}}" title="Edit">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>
                    <a class="btn btn-default formConfirm" href="{{url("/cabinet/schedule-payment/delete/{$item['schedule_entity_id']}")}}"
                       title="Delete"
                       data-title="Delete Schedule Payment"
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
