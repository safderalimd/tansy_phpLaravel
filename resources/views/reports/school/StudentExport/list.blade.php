@extends('layout.cabinet')

@section('title', 'Student Export')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Student Export</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" action="/cabinet/student-export/pdf" target="_blank" method="GET">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <div class="col-md-4">
                                <select id="primary_key_id" class="form-control" name="pk">
                                    @foreach($export->dropdown() as $option)
                                        <option value="{{ $option['primary_key_id'] }}">{{ $option['drop_down_list_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button id="generate-report" class="btn btn-primary" type="submit">Generate Report</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
