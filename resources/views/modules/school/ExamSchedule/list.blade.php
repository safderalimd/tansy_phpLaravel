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

                    <!-- separate post form to map subjects -->
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal" action="{{url("/cabinet/exam-schedule/map-subjects/")}}" method="POST">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-2 text-center">
                                        @include('commons.select', [
                                            'label'   => 'Exam' ,
                                            'name'    => 'exam_entity_id',
                                            'options' => $schedule->exam(),
                                            'keyId'   => 'exam_entity_id',
                                            'keyName' => 'exam',
                                        ])
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-primary grid_btn" type="submit">Map Subjects</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <hr/>

                   <table class="table table-striped table-bordered table-hover" data-datatable>
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

            @foreach($schedule->scheduleExamGrid() as $item)
            <tr>
                <td class="text-center">
                    <input type="checkbox" class="subject-entity-id" name="subject_id" value="{{$item['subject_entity_id']}}">
                </td>
                <td>{{$item['class_name']}}</td>
                <td>{{$item['subject']}}</td>
                <td>{{$item['max_marks']}}</td>
                <td>{{$item['exam_date']}}</td>
                <td>{{$item['exam_time']}}</td>
                <td>
                    <a class="btn btn-default formConfirm" href="{{url("/cabinet/exam-schedule/delete?class_entity_id={$item['class_entity_id']}&subject_entity_id={$item['subject_entity_id']}&exam_entity_id={$item['exam_entity_id']}")}}"
                       title="Delete"
                       data-title="Delete Exam Schedule"
                       data-message="Are you sure to delete the selected record?"
                    >
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </a>
                </td>
            </tr>
            @endforeach
                        </tbody>
                    </table>


                <form class="form-horizontal" id="schedule-rows-form" action="{{url("/cabinet/exam-schedule/schedule-rows/")}}" method="POST">
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
                                  <input id="exam_start_time" class="form-control" type="text" name="exam_start_time" value="{{ v('exam_start_time') }}" placeholder="Start Time">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label class="col-md-4 control-label" for="exam_end_time">End Time</label>
                              <div class="col-md-8">
                                  <input id="exam_end_time" class="form-control" type="text" name="exam_end_time" value="{{ v('exam_end_time') }}" placeholder="End Time">
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

    $('#toggle-subjects').change(function() {
        if($(this).is(":checked")) {
            // only for the ones on the first page
            $('.subject-entity-id').prop('checked', true);
        } else {
            $('.subject-entity-id').prop('checked', false);
        }
    });

    $('#schedule-rows-form').submit(function() {
        var exam_entity_id = $('#exam_entity_id').val();
        $('#hidden_exam_entity_id').val(exam_entity_id);

        // set the subjec ids
        var subjectIds = $('.subject-entity-id:checked').map(function() {
            return this.value;
        }).get();

        if (subjectIds.length == 0) {
            alert("No subjects are selected.");
            return false;
        }

        $('#hidden_class_subject_ids').val(subjectIds.join(','));

        return true;
    });
</script>
@endsection