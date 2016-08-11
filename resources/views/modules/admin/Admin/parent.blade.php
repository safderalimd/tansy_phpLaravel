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
                    <h4>
                        @foreach ($admin->boxes as $index => $box)
                            <a href="{{$admin->boxLink($index)}}">{{$admin->boxLabel($index)}}</a>
                            <br/><br/>
                        @endforeach
                    </h4>
                </div>
            </div>
        </div>

        <div class="row">
            @include('modules.admin.Admin.events')
        </div>
    </div>
</div>

@endsection
