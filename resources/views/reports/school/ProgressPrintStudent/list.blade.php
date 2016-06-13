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

            <form class="form-inline" id="generate-report-form" action="/cabinet/progress-print--student/pdf" target="_blank" method="GET">
                <input type="hidden" id="random_id" name="ri" value="">

                <div class="form-group" style="margin:0px 10px;">
                    <label class="" for="exam_entity_id">Exam</label>
                    <select id="exam_entity_id" class="form-control" name="ei">
                        @foreach($progress->exam() as $option)
                            <option value="{{ $option['exam_entity_id'] }}">{{ $option['exam'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="margin:0px 10px;">
                    <label class="" for="class_entity_id">Class</label>
                    <select id="class_entity_id" class="form-control" name="ci">
                        @foreach($progress->classes() as $option)
                            <option value="{{ $option['class_entity_id'] }}">{{ $option['class_name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <button id="generate-report" style="margin:0px 10px;" class="btn btn-primary" type="submit">Generate Student Progress Report</button>
            </form>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">

    $('#generate-report-form').submit(function() {
        $('#random_id').val(Date.now());
        return true;
    });

</script>
@endsection
