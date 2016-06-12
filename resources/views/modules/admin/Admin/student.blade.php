@extends('layout.dashboard')

@section('title', 'Home - v1')

@section('content')

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-title">
                    <h2>Home - v1</h2>
                    <h4>
                        <a href="/cabinet/student-dashboard?sei={{session('user.userID')}}&csi={{$admin->boxRawValue(0)}}">{{$admin->boxLabel(0)}}</a>
                    </h4>
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
