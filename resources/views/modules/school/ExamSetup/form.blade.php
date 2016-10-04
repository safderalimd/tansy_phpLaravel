@extends('layout.cabinet')

@section('title', 'Exam Setup')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th"></i>
                    <h3>Exam Setup{{ form_label() }}</h3>
                </div>

                <div class="panel-body edit_form_wrapper">
                    <section class="form_panel">

                    @include('commons.errors')

                    <form id="exam-setup-form" class="form-horizontal" action="{{ form_action_full() }}" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="main-exam-entity-id">Main Exam</label>
                            <div class="col-md-8">
                                <select disabled="disabled" id="main-exam-entity-id" class="form-control" name="main_exam_entity_id">
                                    @foreach($setup->examDropdown() as $option)
                                        <option {{activeSelect($option['exam_entity_id'], 'eei')}} value="{{$option['exam_entity_id']}}">{{$option['exam']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @if (!$setup->isNewRecord())
                            @include('commons.select', [
                                'label'    => 'Exam' ,
                                'name'     => 'exam_entity_id',
                                'options'  => $setup->examDropdown(),
                                'keyId'    => 'exam_entity_id',
                                'keyName'  => 'exam',
                                'none'     => 'Select an exam..',
                            ])
                        @endif

                        @include('commons.select', [
                            'label'    => 'Sub Exam' ,
                            'name'     => 'sub_exam_entity_id',
                            'options'  => $setup->subExamDropdown(),
                            'keyId'    => 'exam_entity_id',
                            'keyName'  => 'exam',
                            'none'     => 'Select an exam..',
                        ])

                        @include('commons.select', [
                            'label'    => 'Grade System' ,
                            'name'     => 'grade_system_id',
                            'options'  => $setup->gradingSystem(),
                            'keyId'    => 'grade_system_id',
                            'keyName'  => 'grade_type',
                            'none'     => 'Select a grade system..',
                            'required' => true,
                        ])

                        @if ($setup->isNewRecord())
                            @include('commons.select', [
                                'label'    => 'Class' ,
                                'name'     => 'class_entity_id',
                                'options'  => $setup->classDropdown(),
                                'keyId'    => 'entity_id',
                                'keyName'  => 'drop_down_list_name',
                                'none'     => 'Select a class..',
                            ])

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="">Subjects</label>
                                <div class="col-sm-8">
                                    @foreach ($setup->subject() as $subject)
                                        <label class="checkbox-inline no_indent">
                                            <input class="subject-checkbox" name="{{$subject['subject_entity_id']}}" value="{{$subject['subject_entity_id']}}" type="checkbox"> {{$subject['subject']}}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <input type="hidden" id="subjectIDS" name="subjectIDS" value="">

                        @else
                            @include('commons.select', [
                                'label'    => 'Class' ,
                                'name'     => 'class_entity_id',
                                'options'  => $setup->classes(),
                                'keyId'    => 'class_entity_id',
                                'keyName'  => 'class_name',
                                'none'     => 'Select a class..',
                            ])

                            @include('commons.select', [
                                'label'    => 'Class' ,
                                'name'     => 'subject_entity_id',
                                'options'  => $setup->subject(),
                                'keyId'    => 'subject_entity_id',
                                'keyName'  => 'subject',
                                'none'     => 'Select a subject..',
                            ])
                        @endif

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

                        {{--
                        <div class="form-group">
                            <label class="col-md-4 control-label">Paper Instance</label>
                            <div class="col-md-8">
                                <div class="well well-sm">{{ v('paper_instance') }} &nbsp;</div>
                            </div>
                        </div>
                        --}}

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="exam_date">Exam Date</label>
                            <div class="col-md-8">
                                <div class="input-group date">
                                    @if ($setup->isNewRecord())
                                        <input id="exam_date" class="form-control" type="text" name="exam_date" value="{{current_system_date()}}" placeholder="Exam Date">
                                    @else
                                        <input id="exam_date" class="form-control" type="text" name="exam_date" value="{{ v('exam_date') }}" placeholder="Exam Date">
                                    @endif
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
                                <a href="{{ url("/cabinet/exam-setup").query_string()}}" class="btn btn-default cancle_btn">Cancel</a>
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
    @if ($setup->isNewRecord())

        $('#exam-setup-form').submit(function() {
            if (! $('#exam-setup-form').valid()) {
                return false;
            }

            var subjectIds = $('.subject-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            $('#subjectIDS').val(subjectIds.join('|'));

            return true;
        });

    @endif

    $('#exam-setup-form').validate({
        rules: {
            grade_system_id: {
                requiredSelect: true
            }
        }
    });
</script>
@endsection

@section('styles')
<style type="text/css">
    .checkbox-inline.no_indent,
    .checkbox-inline.no_indent+.checkbox-inline.no_indent {
        margin-left: 0;
        margin-right: 10px;
        width: 150px;
    }
    .checkbox-inline.no_indent:last-child {
        margin-right: 0;
    }
</style>
@endsection
