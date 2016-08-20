@extends('layout.cabinet')

@section('title', 'Exam Schedule')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th"></i>
                    <h3>Exam Schedule{{ form_label() }}</h3>
                </div>

                <div class="panel-body edit_form_wrapper">
                    <section class="form_panel">

                    @include('commons.errors')

                    <form id="product-form" class="form-horizontal" action="{{ form_action_full() }}" method="POST">
                        {{ csrf_field() }}

                        @include('commons.select', [
                            'label'    => 'Exam' ,
                            'name'     => 'exam_entity_id',
                            'options'  => $schedule->examDropdown(),
                            'keyId'    => 'exam_entity_id',
                            'keyName'  => 'exam',
                            'none'     => 'Select an exam..',
                        ])

                        @include('commons.select', [
                            'label'    => 'Sub Exam' ,
                            'name'     => 'sub_exam_entity_id',
                            'options'  => $schedule->subExamDropdown(),
                            'keyId'    => 'exam_entity_id',
                            'keyName'  => 'exam',
                            'none'     => 'Select an exam..',
                        ])

                        @include('commons.select', [
                            'label'    => 'Class' ,
                            'name'     => 'class_entity_id',
                            'options'  => $schedule->classes(),
                            'keyId'    => 'class_entity_id',
                            'keyName'  => 'class_name',
                            'none'     => 'Select a class..',
                        ])

                        @include('commons.select', [
                            'label'    => 'Class' ,
                            'name'     => 'subject_entity_id',
                            'options'  => $schedule->subject(),
                            'keyId'    => 'subject_entity_id',
                            'keyName'  => 'subject',
                            'none'     => 'Select a subject..',
                        ])

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="max_marks">Max Marks</label>
                            <div class="col-md-8">
                                <input id="max_marks" class="form-control" type="text" name="max_marks" value="{{ v('max_marks') }}" placeholder="Max Marks">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="average_reduced_marks">Average Reduced Marks</label>
                            <div class="col-md-8">
                                <input id="average_reduced_marks" class="form-control" type="text" name="average_reduced_marks" value="{{ v('average_reduced_marks') }}" placeholder="Average Reduced Marks">
                            </div>
                        </div>

                        <!--
                        <div class="form-group">
                            <label class="col-md-4 control-label">Paper Instance</label>
                            <div class="col-md-8">
                                <div class="well well-sm">{{ v('paper_instance') }} &nbsp;</div>
                            </div>
                        </div>
                        -->

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

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="exam_start_time">Exam Start Time</label>
                            <div class="col-md-8">
                                <div class="input-group datetimepicker">
                                    <input id="exam_start_time" class="form-control datetimepicker" type="text" name="exam_start_time" value="{{ v('exam_start_time') }}" placeholder="Start Time">
                                    <span class="input-group-addon" style="cursor:pointer;">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="exam_end_time">Exam End Time</label>
                            <div class="col-md-8">
                                <div class="input-group datetimepicker">
                                    <input id="exam_end_time" class="form-control datetimepicker" type="text" name="exam_end_time" value="{{ v('exam_end_time') }}" placeholder="End Time">
                                    <span class="input-group-addon" style="cursor:pointer;">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row grid_footer">
                           <div class="col-md-offset-4 col-md-8">
                                <button class="btn btn-primary grid_btn" type="submit">Save</button>
                                <a href="{{ url("/cabinet/exam-schedule")}}" class="btn btn-default cancle_btn">Cancel</a>
                            </div>
                        </div>
                    </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">


</script>
@endsection
