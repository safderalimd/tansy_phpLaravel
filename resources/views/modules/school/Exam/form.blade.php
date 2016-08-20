@extends('layout.cabinet')

@section('title', 'Exam')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
			    <div class="panel-heading">
                	<i class="glyphicon glyphicon-th"></i>
                	<h3>Exam{{ form_label() }}</h3>
                </div>

                <div class="panel-body edit_form_wrapper">
                    <section class="form_panel">

                    @include('commons.errors')

                    <form id="exam-form" class="form-horizontal" action="{{ form_action() }}" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <div class="checkbox">
                                    <label>
                                        @if($exam->isNewRecord())
                                            <input checked="checked" name="active" type="checkbox" disabled readonly> Active
                                        @else
                                            <input {{ c('active') }} name="active" type="checkbox"> Active
                                        @endif
                                    </label>
                                </div>
                            </div>
                        </div>

               			<div class="form-group">
                            <label class="col-md-4 control-label required" for="exam_name">Exam</label>
                            <div class="col-md-8">
                                <input id="exam_name" class="form-control" type="text" name="exam_name" value="{{ v('exam_name') }}" placeholder="Exam">
                            </div>
                        </div>

                        @include('commons.select', [
                            'label'    => 'Exam Type' ,
                            'name'     => 'exam_type_id',
                            'options'  => $exam->examTypes(),
                            'keyId'    => 'exam_type_id',
                            'keyName'  => 'exam_type',
                            'none'     => 'Select an exam type..',
                            'required' => true,
                        ])

                        @include('commons.select', [
                            'label'    => 'Grade System' ,
                            'name'     => 'grade_system_id',
                            'options'  => $exam->gradingSystem(),
                            'keyId'    => 'grade_system_id',
                            'keyName'  => 'grade_type',
                            'none'     => 'Select a grade system..',
                            'required' => true,
                        ])

{{--                         include('commons.select', [
                            'label'    => 'Student Report Version' ,
                            'name'     => 'student_report_version',
                            'options'  => $exam->studentReport(),
                            'keyId'    => 'student_report_version',
                            'keyName'  => 'student_report_version',
                            'none'     => 'Select a report version..',
                        ])
 --}}
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="exam_short_code">Exam Short Code</label>
                            <div class="col-md-8">
                                <input id="exam_short_code" class="form-control" type="text" name="exam_short_code" value="{{ v('exam_short_code') }}" placeholder="Exam Short Code">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <label class="checkbox-inline no_indent">
                                    <input {{ c('attendance_jan') }} name="attendance_jan" type="checkbox"> Jan
                                </label>
                                <label class="checkbox-inline no_indent">
                                    <input {{ c('attendance_feb') }} name="attendance_feb" type="checkbox"> Feb
                                </label>
                                <label class="checkbox-inline no_indent">
                                    <input {{ c('attendance_mar') }} name="attendance_mar" type="checkbox"> Mar
                                </label>
                                <label class="checkbox-inline no_indent">
                                    <input {{ c('attendance_apr') }} name="attendance_apr" type="checkbox"> Apr
                                </label>
                                <label class="checkbox-inline no_indent">
                                    <input {{ c('attendance_may') }} name="attendance_may" type="checkbox"> May
                                </label>
                                <label class="checkbox-inline no_indent">
                                    <input {{ c('attendance_jun') }} name="attendance_jun" type="checkbox"> Jun
                                </label>
                                <label class="checkbox-inline no_indent">
                                    <input {{ c('attendance_jul') }} name="attendance_jul" type="checkbox"> Jul
                                </label>
                                <label class="checkbox-inline no_indent">
                                    <input {{ c('attendance_aug') }} name="attendance_aug" type="checkbox"> Aug
                                </label>
                                <label class="checkbox-inline no_indent">
                                    <input {{ c('attendance_sep') }} name="attendance_sep" type="checkbox"> Sep
                                </label>
                                <label class="checkbox-inline no_indent">
                                    <input {{ c('attendance_oct') }} name="attendance_oct" type="checkbox"> Oct
                                </label>
                                <label class="checkbox-inline no_indent">
                                    <input {{ c('attendance_nov') }} name="attendance_nov" type="checkbox"> Nov
                                </label>
                                <label class="checkbox-inline no_indent">
                                    <input {{ c('attendance_dec') }} name="attendance_dec" type="checkbox"> Dec
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="facility_ids">Facility</label>
                            <div class="col-md-8">
                                <?php
                                    if (!is_array($exam->selectedFacilities)) {
                                        $exam->selectedFacilities = [];
                                    }
                                ?>
                                <select id="facility_ids" class="form-control" name="facility_ids">
                                    <option value="none">Select a facility..</option>
                                    @foreach($exam->facilities() as $option)
                                        <option @if(in_array($option['facility_entity_id'], $exam->selectedFacilities)) selected @endif value="{{$option['facility_entity_id']}}">{{$option['facility_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="reporting_order">Reporting Order</label>
                            <div class="col-md-8">
                                <input id="reporting_order" class="form-control" type="text" name="reporting_order" value="{{ v('reporting_order') }}" placeholder="Reporting Order">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="progress_card_reporting_order">Card Reporting Order</label>
                            <div class="col-md-8">
                                <input id="progress_card_reporting_order" class="form-control" type="text" name="progress_card_reporting_order" value="{{ v('progress_card_reporting_order') }}" placeholder="Card Reporting Order">
                            </div>
                        </div>

                        <div class="row grid_footer">
                           <div class="col-md-8 col-md-offset-4">
                                <button class="btn btn-primary grid_btn" type="submit">Save</button>
                                <a href="{{ url("/cabinet/exam")}}" class="btn btn-default cancle_btn">Cancel</a>
                            </div>
                        </div>
                    </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style type="text/css">
    .checkbox-inline.no_indent,
    .checkbox-inline.no_indent+.checkbox-inline.no_indent {
        margin-left: 0;
        margin-right: 10px;
        width: 70px;
    }
    .checkbox-inline.no_indent:last-child {
        margin-right: 0;
    }
</style>
@endsection

@section('scripts')
<script type="text/javascript">

    $(document).ready(function() {
        $('#exam-form').validate({
            rules: rules
        });

        change_report_required();

        $('#exam_type_id').change(function() {
            change_report_required();
            $('#student_report_version').valid();
        });
    });

    var rules = {
        exam_name: {
            required: true,
            minlength: 3,
            maxlength: 100
        },
        exam_type_id: {
            requiredSelect: true
        },
        grade_system_id: {
            requiredSelect: true
        },
        student_report_version: {

        },
        facility_ids: {
            requiredSelect: true
        },
        reporting_order: {
            required: true,
            number: true,
            min: 0
        },
        progress_card_reporting_order: {
            required: true,
            number: true,
            min: 0,
            max:999
        }
    };

    function change_report_required() {
        notRequiredElemetn('#student_report_version');
        $('#student_report_version').rules('remove', 'requiredSelect');

        if ($('#exam_type_id option:selected').text().trim() == 'Main Exam') {
            $('#student_report_version').rules('add', 'requiredSelect');
            makeRequiredElement('#student_report_version');
        }
    }

    function makeRequiredElement(elem) {
        $(elem).closest('.form-group').find('.control-label').addClass('required');
    }

    function notRequiredElemetn(elem) {
        $(elem).closest('.form-group').find('.control-label').removeClass('required');
    }

</script>
@endsection
