@extends('layout.cabinet')

@section('title', 'Home - v1')
@section('screen-name', 'dashboard square-boxes')

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
                                                {!! $admin->symbol(0) !!} {{$admin->boxValue(0)}}
                                            </div>
                                            <div class="stat-panel-title text-uppercase">
                                                {{$admin->boxLabel(0)}}
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
                                                {!! $admin->symbol(1) !!} {{$admin->boxValue(1)}}
                                            </div>
                                            <div class="stat-panel-title text-uppercase">
                                                {{$admin->boxLabel(1)}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @include('modules.admin.Admin.events')
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

