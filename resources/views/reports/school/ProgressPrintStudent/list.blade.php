@extends('layout.cabinet')

@section('title', 'Student Progress')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Student Progress</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" id="generate-report-form" action="/cabinet/pdf---student-progress-v1/pdf" target="_blank" method="GET">
                <input type="hidden" id="random_id" name="ri" value="">

                <div class="form-group">
                    <label class="col-md-1 control-label" for="exam_entity_id">Exam</label>
                    <div class="col-md-3">
                        <select id="exam_entity_id" class="form-control" name="ei">
                            <option value="none">Select an exam..</option>
                            @foreach($progress->exam() as $option)
                                <option value="{{ $option['exam_entity_id'] }}">{{ $option['exam'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-1 control-label" for="class_entity_id">Class</label>
                    <div class="col-md-3">
                        <select id="class_entity_id" class="form-control" name="ci">
                            <option value="none">Select a class..</option>
                            @foreach($progress->classes() as $option)
                                <option value="{{ $option['class_entity_id'] }}">{{ $option['class_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-md-offset-1">
                        <button id="generate-report" class="btn btn-primary" type="submit">Generate Student Progress Report</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">

    $('#generate-report-form').submit(function() {
        if (! $('#generate-report-form').valid()) {
            return false;
        }

        if ($('#exam_entity_id option:selected').val() == 'none') {
            alert('Please select an exam.');
            return false;
        }

        if ($('#class_entity_id option:selected').val() == 'none') {
            alert('Please select a class.');
            return false;
        }

        $('#random_id').val(Date.now());
        return true;
    });

    $('#generate-report-form').validate({
        rules: {
            ei: {
                requiredSelect: true
            },
            ci: {
                requiredSelect: true
            }
        }
    });
</script>
@endsection
