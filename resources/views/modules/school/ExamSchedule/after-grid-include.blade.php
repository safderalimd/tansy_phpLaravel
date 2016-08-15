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
                        <input id="exam_date" class="form-control" type="text" name="exam_date" value="" placeholder="Exam Date">
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
                  <input id="max_marks" class="form-control" type="text" name="max_marks" value="" placeholder="Max Marks">
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
                    <input id="exam_start_time" class="form-control datetimepicker" type="text" name="exam_start_time" value="" placeholder="Start Time">
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
                    <input id="exam_end_time" class="form-control datetimepicker" type="text" name="exam_end_time" value="" placeholder="End Time">
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

</form>

