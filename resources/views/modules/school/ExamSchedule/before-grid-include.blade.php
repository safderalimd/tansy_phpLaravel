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
                        @foreach($schedule->examDropdown() as $option)
                            <option {{activeSelect($option['exam_entity_id'], 'eid')}} value="{{$option['exam_entity_id']}}">{{$option['exam']}}</option>
                        @endforeach
                    </select>
                </div>
                {{--
                <div class="col-md-4">
                    <button class="btn btn-primary grid_btn" type="submit">MAP ALL SUBJECTS TO EXAM</button>
                </div>
                 --}}
            </div>
        </div>
    </div>
</form>

<hr/>
