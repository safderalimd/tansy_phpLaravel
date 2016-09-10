@extends('layout.cabinet')

@section('title', 'Student Detail')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Student Detail</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" target="_blank" id="generate-report-form" action="/cabinet/pdf---student/pdf" method="GET">
                <input type="hidden" id="random_id" name="ri" value="">

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
                    <label class="col-md-1 control-label">Student</label>
                    <div class="col-md-3">
                        <select id="student_entity_id" class="form-control" name="si">
                            @foreach($export->students() as $option)
                                <option data-classId="{{ $option['class_entity_id'] }}" value="{{ $option['student_entity_id'] }}">{{ $option['student_full_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-md-offset-1">
                        <button id="generate-report" class="btn btn-primary" type="submit">Generate Report</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">

    var allStudentOptions;

    function initStudentOptions() {
        allStudentOptions = $('#student_entity_id option');
        removeAllStudentOptions();
        $('#student_entity_id').append('<option value="none">Select a student...</option>');
    }

    function getClassId() {
        return $('#class_entity_id option:selected').val();
    }

    function removeAllStudentOptions() {
        $('#student_entity_id option').remove();
    }

    function populateStudentsSelectbox(accounts) {
        $('#student_entity_id').prepend('<option value="none">Select a student...</option>');
        $(accounts).each(function() {
            $('#student_entity_id').append($(this));
        });
        $('#student_entity_id option[value=none]').prop('selected', 'selected');
    }

    function updateStudents() {
        removeAllStudentOptions();

        var classId = getClassId();
        var filteredStudents = $(allStudentOptions).filter(function() {
            if ($(this).attr('data-classId') == classId) {
                return true;
            }
            return false;
        }).get();

        populateStudentsSelectbox(filteredStudents);
    }

    $('#class_entity_id').change(function() {
        updateStudents();
    });

    $(document).ready(function() {
        initStudentOptions();
    });


    $('#generate-report-form').submit(function() {
        if (! $('#generate-report-form').valid()) {
            return false;
        }

        if ($('#class_entity_id option:selected').val() == 'none') {
            alert('Select a class.');
            return false;
        }

        if ($('#student_entity_id option:selected').val() == 'none') {
            alert('Select a student.');
            return false;
        }

        $('#random_id').val(Date.now());
        return true;
    });

    $('#generate-report-form').validate({
        rules: {
            ci: {
                requiredSelect: true
            },
            si: {
                requiredSelect: true
            }
        }
    });

</script>
@endsection
