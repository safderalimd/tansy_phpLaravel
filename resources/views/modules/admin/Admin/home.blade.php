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

            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body bk-danger text-light">
                            <div class="stat-panel text-center">
                                <div class="stat-panel-number h1">
                                    {{nr($admin->employee_absentee)}}
                                </div>
                                <div class="stat-panel-title text-uppercase h5">
                                    Employee Absence
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body bk-danger text-light">
                            <div class="stat-panel text-center">
                                <div class="stat-panel-number h1">
                                    {{sms($admin->sms_send_count)}}
                                </div>
                                <div class="stat-panel-title text-uppercase h5">
                                    Sms Send Count
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br/>

            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body bk-danger text-light">
                            <div class="stat-panel text-center">
                                <div class="stat-panel-number h1">
                                    {{amount($admin->collection_amount)}}
                                </div>
                                <div class="stat-panel-title text-uppercase h5">
                                    Collection Amount
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body bk-danger text-light">
                            <div class="stat-panel text-center">
                                <div class="stat-panel-number h1">
                                    {{amount($admin->dueAmount)}}
                                </div>
                                <div class="stat-panel-title text-uppercase h5">
                                    Fee Due
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
