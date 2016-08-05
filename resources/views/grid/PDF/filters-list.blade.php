@extends('layout.cabinet')

@section('title', $grid->screenName)

@section('content')

<?php

    $columns = $grid->columns();
    $buttons = $grid->buttons();

?>

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>{{$grid->screenName}}</h3>
            @if ($grid->settings->hasInsertButton())
                <a href="{{url(app('request')->path() . '/create')}}" class="btn pull-right btn-default">Add new record</a>
            @endif
        </div>
        <div class="panel-body">

            @include('commons.errors')

            @if (isset($options['beforeGridInclude'])) @include($options['beforeGridInclude']) @endif

            <form class="form-inline" id="generate-report-form" action="{{form_action_full()}}" target="_blank" method="GET">
                <input type="hidden" id="random_id" name="ri" value="">
                <input type="hidden" id="pdf_flag" name="pdf" value="1">

                @include('grid.filters')

                <div class="row">
                    <div class="" style="max-width: 450px; padding-left: 215px;">
                        <button id="generate-report" class="btn btn-primary" type="submit">Generate Report</button>
                    </div>
                </div>
            </form>

            @include('commons.modal')

        </div>
    </div>
</div>
@if (isset($options['afterGridInclude'])) @include($options['afterGridInclude']) @endif
@endsection

@section('scripts')
@if (isset($options['scriptsInclude'])) @include($options['scriptsInclude']) @endif
<script type="text/javascript">

    $('#generate-report-form').submit(function() {
        if (! $('#generate-report-form').valid()) {
            return false;
        }

        $('#random_id').val(Date.now());
        return true;
    });

    $('#generate-report-form').validate();

</script>
@endsection
