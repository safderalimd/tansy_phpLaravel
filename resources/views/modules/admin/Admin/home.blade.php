@extends('layout.cabinet')

@section('title', 'Home v1')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
    	<div class="panel-heading">
        	<i class="glyphicon glyphicon-th-list"></i>
        	<h3>Home v1</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            Employee Absentee:{{nr($admin->employee_absentee)}}
            <br/>

            Sms Send Count:{{sms($admin->sms_send_count)}}
            <br/>

            Collection Amount:{{amount($admin->collection_amount)}}
            <br/>

            Fee Due:{{amount($admin->dueAmount)}}
            <br/>


        </div>
    </div>
</div>

@endsection
