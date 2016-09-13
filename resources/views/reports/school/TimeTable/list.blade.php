@extends('layout.cabinet')

@section('title', 'Time Table')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Time Table</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" target="_blank" id="generate-report-form" action="/cabinet/pdf---time-table/pdf" method="GET">
                <input type="hidden" id="random_id" name="ri" value="">
                <input type="hidden" id="teacher_or_class" name="tc" value="c">

                <div class="form-group">
                    <label class="col-md-1 control-label">Class</label>
                    <div class="col-md-3">
                        <select id="class_entity_id" class="form-control" name="ci">
                            <option value="none">Select a class..</option>
                            @foreach($export->classes() as $option)
                                <option value="{{ $option['class_entity_id'] }}">{{ $option['class_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-1 control-label">Teacher</label>
                    <div class="col-md-3">
                        <select id="teacher_entity_id" class="form-control" name="ti">
                            <option value="none">Select a teacher..</option>
                            @foreach($export->teachers() as $option)
                                <option value="{{ $option['teacher_entity_id'] }}">{{ $option['teacher_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-1 control-label" for="start_date">Week Date</label>
                    <div class="col-md-3">
                        <div class="input-group date">
                            <input id="start_date" class="form-control" type="text" name="dt" value="" placeholder="Week Date">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><span
                                            class="glyphicon glyphicon-calendar"></span></button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-md-offset-1">
                        <button id="generate-report" class="btn btn-primary" type="submit">Generate Report</button>
                        <span style="display:none;" id="eid-error" class="help-block">Select either a class or a teacher.</span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">

    $('#class_entity_id').change(function() {
        $('#teacher_entity_id').val('none');
        $('#teacher_or_class').val('c');
        $('#eid-error').hide();
    });

    $('#teacher_entity_id').change(function() {
        $('#class_entity_id').val('none');
        $('#teacher_or_class').val('t');
        $('#eid-error').hide();
    });

    $('#generate-report-form').submit(function() {
        if ($('#teacher_entity_id option:selected').val() == 'none'
            && $('#class_entity_id option:selected').val() == 'none') {

            $('#eid-error').show();
            return false;
        }

        $('#random_id').val(Date.now());
        return true;
    });

</script>
@endsection
