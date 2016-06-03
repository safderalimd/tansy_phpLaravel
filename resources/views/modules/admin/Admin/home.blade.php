@extends('layout.dashboard')

@section('title', 'Home - v1')

@section('content')

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-title">
                    <h2>Home - v1</h2>
                </div>

                <div class="row">
                    <div class="col-md-12">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-info text-light">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1">
                                                {{nr($admin->employee_absentee)}}
                                            </div>
                                            <div class="stat-panel-title text-uppercase">
                                                Employee Absence
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-danger text-light">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1">
                                                {{sms($admin->sms_send_count)}}
                                            </div>
                                            <div class="stat-panel-title text-uppercase">
                                                Sms Send Count
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-warning text-light">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1">
                                                <i class="fa fa-inr"></i> {{amount($admin->collection_amount)}}
                                            </div>
                                            <div class="stat-panel-title text-uppercase">
                                                Collection Amount
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-success text-light">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1">
                                                <i class="fa fa-inr"></i> {{amount($admin->dueAmount)}}
                                            </div>
                                            <div class="stat-panel-title text-uppercase">
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
        </div>
    </div>
</div>

@endsection

@section('styles')
<style type="text/css">
    .panel-body {
        height: 200px;
    }
    .stat-panel {
        margin-top: 50px;
    }
</style>
@endsection
