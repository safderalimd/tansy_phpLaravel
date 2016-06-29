@extends('layout.cabinet')

@section('title', 'Admission')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Student Admission</h3>
            <a href="{!!url('/cabinet/admission/create/')!!}" class="btn pull-right btn-default">Add new record</a>
        </div>
        <div class="panel-body">

            @include('commons.errors')

           <table class="table table-striped table-bordered table-hover" data-datatable>
            <thead>
                <tr>
                    <th class="text-center"><input type="checkbox" id="toggle-subjects" name="toggle-checkbox" value=""></th>
                    <th>Student Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    <th>Admission # <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    <th>Admission Date <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    <th>Admitted <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    <th>Current Class <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    <th>Status <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

    @foreach($admission->admissionGrid() as $student)
    <tr>
        <td class="text-center">
            <input type="checkbox" class="admission-id" name="admission_id" value="{{$student['admission_id']}}">
        </td>
        <td>{{$student['student_full_name']}}</td>
        <td>{{$student['admission_number']}}</td>
        <td>{{style_date($student['admission_date'])}}</td>
        <td>{{$student['admitted_to']}}</td>
        <td>{{$student['current_class_name']}}</td>
        <td>{{$student['admission_status']}}</td>
        <td>
            <a class="btn btn-default" href="{{url("/cabinet/admission/edit/{$student['admission_id']}")}}" title="Edit">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
            </a>
            <a class="btn btn-default formConfirm" href="{{url("/cabinet/admission/delete/{$student['admission_id']}")}}"
               title="Delete"
               data-title="Delete Admission"
               data-message="Are you sure to delete the selected record?"
            >
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
            </a>
        </td>
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

    <form class="form-horizontal" id="move-students-form" action="{{url("/cabinet/admission/move-students/")}}" method="POST">
        {{ csrf_field() }}

        <input type="hidden" name="admission_ids" id="admission_ids" value="">

        <div class="form-group">
            <label class="col-md-2 control-label" for="fiscal_years">Move to Fiscal Year</label>
            <div class="col-md-4">
                <select id="fiscal_years" class="form-control" name="move_to_fiscal_year_entity_id">
                    <option value="none">Select a fiscal year..</option>
                    @foreach($admission->fiscalYears() as $year)
                        <option value="{{$year['fiscal_year_entity_id']}}">{{$year['fiscal_year']}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label" for="move_to_class">Move to class</label>
            <div class="col-md-4">
                <select id="move_to_class" class="form-control" name="move_to_class_entity_id">
                    <option value="none">Select a class..</option>
                    @foreach($admission->classes() as $class)
                        <option value="{{$class['class_entity_id']}}">{{$class['class_name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
           <div class="col-md-4 col-md-offset-2">
                <button type="button" id="uncheck-all-checkboxes" class="btn btn-default">Cancel</button>
                <button type="submit" id="move-admissions-submit" disabled="disabled" class="btn btn-primary">
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

    // Checkbox table header - toggle all checkboxes
    // Todo: only for the ones on the first page
    $('#toggle-subjects').change(function() {
        if($(this).is(":checked")) {
            $('.admission-id').prop('checked', true);
        } else {
            $('.admission-id').prop('checked', false);
        }
    });

    // Cancel Button - deselect all checkboxes
    $('#uncheck-all-checkboxes').on('click', function() {
        $('.admission-id').prop('checked', false);
        $('#toggle-subjects').prop('checked', false);
    });

    // Disable/Enable Move Button depending if checkboxes are selected
    $('.admission-id, #toggle-subjects').change(function() {
        if ($('.admission-id:checked').length > 0) {
            $('#move-admissions-submit').prop('disabled', false);
        } else {
            $('#move-admissions-submit').prop('disabled', true);
        }
    });

    // When submitting the form, prepend all selected checkboxes
    $('#move-students-form').submit(function() {
        var admissionIds = $('.admission-id:checked').map(function() {
            return this.value;
        }).get();

        if (admissionIds.length == 0) {
            alert("No admissions are selected.");
            return false;
        }

        $('#admission_ids').val(admissionIds.join(','));

        return true;
    });

    $('#move-students-form').validate({
        rules: {
            move_to_fiscal_year_entity_id: {
                requiredSelect: true
            },
            move_to_class_entity_id: {
                requiredSelect: true
            }
        }
    });
</script>
@endsection
