@extends('layout.cabinet')

@section('title', 'Exam Setup')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
    	<div class="panel-heading">
        	<i class="glyphicon glyphicon-th-list"></i>
        	<h3>Exam Setup</h3>
            @if (is_numeric(app('request')->input('eei')))
            	<a href="{{url('/cabinet/exam-setup/create?eei='.app('request')->input('eei'))}}" class="btn pull-right btn-default">Add new record</a>
            @endif
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <!-- filter the exams -->
            <form class="form-horizontal" id="select-exam-form" action="{{url_with_query("/cabinet/exam-setup/copy")}}" method="POST">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="exam_entity_id">Exam</label>
                            <div class="col-md-8">
                                <select id="exam_entity_id" class="form-control" name="exam_entity_id">
                                    <option value="none">Select an exam..</option>
                                    @foreach($setup->examDropdown() as $option)
                                        <option {{activeSelect($option['exam_entity_id'], 'eei')}} value="{{$option['exam_entity_id']}}">{{$option['exam']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary grid_btn" type="submit">COPY EXAM SETUP FROM PREVIOUS YEAR</button>
                    </div>
                </div>
            </form>

            <table class="table table-striped table-bordered table-hover" data-datatable>
                <thead>
                    <tr>
                        <th class="text-center"><input type="checkbox" id="toggle-subjects" name="toggle-checkbox" value=""></th>
                        <th>Class Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Subject <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Sub Exam <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Max Marks <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Average Reduced Marks <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($setup->examSetupGrid() as $item)
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="exam-schedule-id" name="exam_schedule_id" value="{{$item['exam_schedule_id']}}">
                        </td>
                        <td>{{$item['class_name']}}</td>
                        <td>{{$item['subject']}}</td>
                        <td>{{$item['sub_exam']}}</td>
                        <td>{{$item['max_marks']}}</td>
                        <td>{{$item['average_reduced_marks']}}</td>
                        <td>
                            <a class="btn btn-default" href="{{url("/cabinet/exam-setup/edit/{$item['exam_schedule_id']}?eei=".app('request')->input('eei'))}}" title="Edit">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            </a>
                            <a class="btn btn-default formConfirm" href="{{url("/cabinet/exam-setup/delete?esi={$item['exam_schedule_id']}&eei=".app('request')->input('eei'))}}"
                               title="Delete"
                               data-title="Delete Exam Setup"
                               data-message="Are you sure to delete the selected record?"
                            >
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <br/>
            <div class="row">
                <form class="form-horizontal" id="delete-rows-form" action="{{url_with_query("/cabinet/exam-setup/delete-multiple")}}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" id="exam_schedule_ids" name="exam_schedule_ids">
                    <button class="btn btn-primary pull-right" disabled="disabled" id="delete-rows-btn" type="submit">Delete Selected Rows</button>
                </form>
            </div>

		    @include('commons.modal')

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
    // reload the page when selecting an exam
    $('#exam_entity_id').change(function() {
        if (this.value == 'none') {
            window.location.href = "/cabinet/exam-setup";
        } else {
            window.location.href = "/cabinet/exam-setup?eei=" + this.value;
        }
    });

    $('#select-exam-form').validate({
        rules: {
            exam_entity_id: {
                requiredSelect: true
            }
        }
    });

    // Checkbox table header - for this page, toggle all checkboxes
    $('#toggle-subjects').change(function() {
        if($(this).is(":checked")) {
            $('.exam-schedule-id').prop('checked', true);
        } else {
            $('.exam-schedule-id').prop('checked', false);
        }
    });

    // Disable/Enable Delete Button depending if checkboxes are selected
    $('.exam-schedule-id, #toggle-subjects').change(function() {
        if ($('.exam-schedule-id:checked').length > 0) {
            $('#delete-rows-btn').prop('disabled', false);
        } else {
            $('#delete-rows-btn').prop('disabled', true);
        }
    });

    // When submitting the form, prepend all selected checkboxes
    $('#delete-rows-form').submit(function() {

        var examIds = $('.exam-schedule-id:checked').map(function() {
            return this.value;
        }).get();

        if (examIds.length == 0) {
            alert("No exams are selected.");
            return false;
        }

        $('#exam_schedule_ids').val(examIds.join('|'));

        return true;
    });

</script>
@endsection
