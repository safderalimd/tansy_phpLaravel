@extends('layout.cabinet')

@section('title', 'Sms History')

@section('content')

        <div class="panel-group sch_class">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th-list"></i>
                    <h3>Sms History</h3>
                </div>
                <div class="panel-body">

                    @include('commons.errors')

            <table class="table table-striped table-bordered table-hover" data-datatable>
                <thead>
                    <tr>
                        <th>SMS Type <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>SMS Message <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>SMS Date <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>SMS Number <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Sent Status <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($student->smsHistory() as $item)
                    <tr>
                        <td>{{$item['sms_type']}}</td>
                        <td>{{$item['sms_message']}}</td>
                        <td>{{$item['sms_date']}}</td>
                        <td>{{phone_number($item['sms_number'])}}</td>
                        <td>{{$item['success_fail_flag']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

                    @include('commons.modal')

                </div>
            </div>
        </div>

@endsection
