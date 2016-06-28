@extends('layout.cabinet')

@section('title', 'Move Student')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Move Student</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" action="" method="POST">
                <div class="row">
                    <div class="col-md-4">

                        <div class="form-group">
                            <label class="col-md-2 control-label" for="class-entity-id-filter">Class</label>
                            <div class="col-md-8">
                                <select id="class-entity-id-filter" class="form-control" name="class-entity-id-filter">
                                    <option value="none">Select a class..</option>
                                    @foreach($move->classes() as $option)
                                        <option {{ activeSelect($option['class_entity_id'], 'cei') }} value="{{ $option['class_entity_id'] }}">{{ $option['class_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

            <hr/>

           <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center"><input type="checkbox" id="toggle-subjects" name="toggle-checkbox" value=""></th>
                    <th>Student name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    <th>Roll Number <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                </tr>
            </thead>
            <tbody>

    @foreach($move->studentsGrid() as $student)
    <tr class="student-tr">
        <td class="text-center">
            <input type="checkbox" data-classid="{{$student['class_entity_id']}}" class="student-entity-id" name="class_student_id" value="{{$student['class_student_id']}}">
        </td>
        <td>{{$student['student_full_name']}}</td>
        <td>{{$student['student_roll_number']}}</td>
    </tr>
    @endforeach


                </tbody>
            </table>

            @include('commons.modal')

        </div>
    </div>
</div>



<div class="row">
<div class="col-md-12">

<form class="form-horizontal" id="move-students-form" action="{{form_action_full()}}" method="POST">
    {{ csrf_field() }}

    <input type="hidden" name="class_student_ids" id="class_student_ids" value="">

        <div class="form-group">
            <label class="col-md-2 control-label" for="move_to_fiscal_year_entity_id">Move to Fiscal Year</label>
            <div class="col-md-4">
                <select id="move_to_fiscal_year_entity_id" class="form-control" name="move_to_fiscal_year_entity_id">
                    <option value="none">Select a fiscal year..</option>
                    @foreach($move->fiscalYears() as $year)
                        <option value="{{$year['fiscal_year_entity_id']}}">{{$year['fiscal_year']}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label" for="move_to_class_entity_id">Move to class</label>
            <div class="col-md-4">
                <select id="move_to_class_entity_id" class="form-control" name="move_to_class_entity_id">
                    <option value="none">Select a class..</option>
                    @foreach($move->classes() as $class)
                        <option value="{{$class['class_entity_id']}}">{{$class['class_name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
           <div class="col-md-4 col-md-offset-2">
                <a href="{{ url("/cabinet/move-student")}}" class="btn btn-default">Cancel</a>
                <button type="submit" id="move-students-submit" disabled="disabled" class="btn btn-primary">
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                    Move Selected Students
                </button>
            </div>
        </div>

</form>
</div>
</div>

@endsection


@section('scripts')
<script type="text/javascript">

    $('#class-entity-id-filter').change(function() {
        updateQueryString();
    });

    function updateQueryString() {
        window.location.href = window.location.href.split('?')[0] + getQueryString();
    }

    // get the query string
    function getQueryString() {
        var cei = $('#class-entity-id-filter option:selected').val();

        var items = [];
        if (cei != "none") {
            items.push('cei='+cei);
        }

        var queryString = items.join('&');
        if (queryString.length > 1) {
            return '?' + queryString;
        }
        return '';
    }

    // Checkbox table header - for this page, toggle all checkboxes
    $('#toggle-subjects').change(function() {
        if($(this).is(":checked")) {
            $('.student-entity-id').prop('checked', true);
        } else {
            $('.student-entity-id').prop('checked', false);
        }
    });

    // Disable/Enable Move Button depending if checkboxes are selected
    $('.student-entity-id, #toggle-subjects').change(function() {
        if ($('.student-entity-id:checked').length > 0) {
            $('#move-students-submit').prop('disabled', false);
        } else {
            $('#move-students-submit').prop('disabled', true);
        }
    });

    // When submitting the form, prepend all selected checkboxes
    $('#move-students-form').submit(function() {
        if (! $('#move-students-form').valid()) {
            return false;
        }

        var studentIds = $('.student-entity-id:checked').map(function() {
            return this.value;
        }).get();

        if (studentIds.length == 0) {
            alert("No students are selected.");
            return false;
        }

        $('#class_student_ids').val(studentIds.join(','));

        return true;
    });

    $('#move-students-form').validate({
        rules: {
            move_to_fiscal_year_entity_id: {
                requiredSelect: true
            },
            move_to_class_entity_id: {
                requiredSelect: true,
                notEqualTo: '#class-entity-id-filter'
            }
        },
        messages: {
            move_to_class_entity_id: {
                notEqualTo: "Please select a different class."
            }
        }
    });

</script>
@endsection
