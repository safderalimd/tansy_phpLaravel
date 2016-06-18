@extends('layout.cabinet')

@section('title', 'Class Progress')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Class Progress</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-inline" id="generate-report-form" action="/cabinet/progress-print--class/pdf" target="_blank" method="GET">
                <input type="hidden" id="random_id" name="ri" value="">

                <div class="form-group" style="margin:0px 10px;">
                    <label class="" for="exam_entity_id">Exam</label>
                    <select id="exam_entity_id" class="form-control" name="ei">
                        <option value="none">Select an exam..</option>
                        @foreach($progress->exam() as $option)
                            <option value="{{ $option['exam_entity_id'] }}">{{ $option['exam'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="margin:0px 10px;">
                    <label class="" for="class_entity_id">Class</label>
                    <select id="class_entity_id" class="form-control" name="ci">
                        <option value="none">Select a class..</option>
                        @foreach($progress->classes() as $option)
                            <option value="{{ $option['class_entity_id'] }}">{{ $option['class_name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <button id="generate-report" style="margin:0px 10px;" class="btn btn-primary" type="submit">Generate Class Progress Report</button>
            </form>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">

    $('#generate-report-form').submit(function() {

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

</script>
@endsection
