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
                        @foreach ($admin->boxes as $index => $box)
                            <a href="{{$admin->boxLink($index)}}">{{$admin->boxLabel($index)}}</a>
                            &nbsp;&nbsp;
                        @endforeach
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
