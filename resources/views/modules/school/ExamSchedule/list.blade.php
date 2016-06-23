@extends('layout.cabinet')

@section('title', 'Exam Schedule')

@section('content')

        <div class="panel-group sch_class">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th-list"></i>
                    <h3>Exam Schedule</h3>
                </div>
                <div class="panel-body">

                    @include('commons.errors')

                    <!-- filter the exams -->
                    <form class="form-horizontal" style="margin-bottom:-15px;" action="{{url_with_query("/cabinet/exam-schedule/map-subjects/")}}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="exam_entity_id">Exam</label>
                                    <div class="col-md-4">
                                        <select id="exam_entity_id" class="form-control" name="exam_entity_id">
                                            <option value="none">Select an exam..</option>
                                            @foreach($schedule->exam() as $option)
                                                <option {{activeSelect($option['exam_entity_id'], 'eid')}} value="{{$option['exam_entity_id']}}">{{$option['exam']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-primary grid_btn" type="submit">MAP ALL SUBJECTS TO EXAM</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <hr/>

                   <table id="exam-schedule-table" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center"><input type="checkbox" id="toggle-subjects" name="toggle-checkbox" value=""></th>
                            <th>Class <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Subject <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Max Marks <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Exam Date <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Exam Time <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

            @foreach($schedule->getExamGrid() as $item)
            <tr>
                <td class="text-center">
                    <input type="checkbox" data-classEntityId="{{$item['class_entity_id']}}" data-subjectEntityId="{{$item['subject_entity_id']}}" class="subject-entity-id" name="subject_id" value="{{$item['subject_entity_id']}}">
                </td>
                <td>{{$item['class_name']}}</td>
                <td>{{$item['subject']}}</td>
                <td>{{$item['max_marks']}}</td>
                <td>{{style_date($item['exam_date'])}}</td>
                <td>{{$item['exam_time']}}</td>
                <td>
                    <a class="btn btn-default formConfirm" href="{{url("/cabinet/exam-schedule/delete?cid={$item['class_entity_id']}&sid={$item['subject_entity_id']}&eid={$item['exam_entity_id']}")}}"
                       title="Delete"
                       data-title="Delete Exam Schedule"
                       data-message="Are you sure to delete the selected record?"
                    >
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete
                    </a>
                </td>
            </tr>
            @endforeach
                        </tbody>
                    </table>


                <form class="form-horizontal" id="schedule-rows-form" action="{{url_with_query("/cabinet/exam-schedule/schedule-rows/")}}" method="POST">
                    {{ csrf_field() }}

                    <input type="hidden" name="hidden_exam_entity_id" id="hidden_exam_entity_id" value="">
                    <input type="hidden" name="hidden_class_subject_ids" id="hidden_class_subject_ids" value="">

                    <!-- first row -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="exam_date">Exam Date</label>
                                <div class="col-md-8">
                                    <div class="input-group date">
                                        <input id="exam_date" class="form-control" type="text" name="exam_date" value="{{ v('exam_date') }}" placeholder="Exam Date">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button"><span
                                                        class="glyphicon glyphicon-calendar"></span></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label class="col-md-4 control-label" for="max_marks">Max Marks</label>
                              <div class="col-md-8">
                                  <input id="max_marks" class="form-control" type="text" name="max_marks" value="{{ v('max_marks') }}" placeholder="Max Marks">
                              </div>
                           </div>
                        </div>
                    </div><br/>

                    <!-- second row -->
                    <div class="row">
                        <div class="col-md-4">
                           <div class="form-group">
                              <label class="col-md-4 control-label" for="exam_start_time">Start Time</label>
                              <div class="col-md-8">
                                <div class="input-group datetimepicker">
                                    <input id="exam_start_time" class="form-control datetimepicker" type="text" name="exam_start_time" value="{{ v('exam_start_time') }}" placeholder="Start Time">
                                    <span class="input-group-addon" style="cursor:pointer;">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label class="col-md-4 control-label" for="exam_end_time">End Time</label>
                              <div class="col-md-8">
                                <div class="input-group datetimepicker">
                                    <input id="exam_end_time" class="form-control datetimepicker" type="text" name="exam_end_time" value="{{ v('exam_end_time') }}" placeholder="End Time">
                                    <span class="input-group-addon" style="cursor:pointer;">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                              </div>
                           </div>
                        </div>
                    </div><br/>

                    <!-- button -->
                    <div class="row">
                        <div class="col-md-8">
                            <button style="margin-right:15px;" class="btn btn-primary grid_btn pull-right" type="submit">Schedule Selected Rows</button>
                        </div>
                    </div>

                    @include('commons.modal')

                </div>
            </div>
        </div>

@endsection

@section('scripts')
<script type="text/javascript">

    // create datatale with checkbox column unsortable
    $('#exam-schedule-table').DataTable( {
        "aoColumnDefs": [
            { 'bSortable': false, 'aTargets': [ 0 ] }
        ],
        "autoWidth": false
    });

    // check/uncheck all checkboxes
    $('#toggle-subjects').change(function() {
        $('.subject-entity-id').prop('checked', false);
        if($(this).is(":checked")) {
            var table = $('.table').DataTable();
            var rows = table.rows({ page: 'current' }).nodes();
            rows.each(function() {
                $('.subject-entity-id', this).prop('checked',true)
            });
        }
    });

    // reset all checkboxes after you change the page
    $('#exam-schedule-table').on('page.dt', function () {
        $('.subject-entity-id').prop('checked', false);
        $('#toggle-subjects').prop('checked', false);
    });

    // reload the page when selecting an exam
    $('#exam_entity_id').change(function() {
        if (this.value == 'none') {
            window.location.href = "/cabinet/exam-schedule";
        } else {
            window.location.href = "/cabinet/exam-schedule?eid=" + this.value;
        }
    });

    $('#schedule-rows-form').submit(function() {
        if (! $('#schedule-rows-form').valid()) {
            return false;
        }

        var exam_entity_id = $('#exam_entity_id').val();
        $('#hidden_exam_entity_id').val(exam_entity_id);

        // set the subjec ids
        var subjectIds = $('.subject-entity-id:checked').map(function() {
            // return this.value;
            return $(this).attr('data-classEntityId') + "-" + $(this).attr('data-subjectEntityId');
        }).get();

        if (subjectIds.length == 0) {
            alert("No subjects are selected.");
            return false;
        }

        $('#hidden_class_subject_ids').val(subjectIds.join(','));

        return true;
    });

    $('#schedule-rows-form').validate({
        rules: {
            exam_date: {
                required: true,
                dateISO: true
            },
            max_marks: {
                required: true,
                number: true,
                min: 0
            },
            exam_start_time: {
                required: true
            },
            exam_end_time: {
                required: true
            }
        }
    });

    $('#exam_date').change(function() {
        $('#exam_date').valid();
    });

</script>
@endsection
