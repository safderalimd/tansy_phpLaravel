@extends('layout.cabinet')

@section('title', 'Class Time Table')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Class Time Table</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" action="" method="POST">

                <div class="form-group">
                    <label class="col-md-1 control-label" for="start_date">Date</label>
                    <div class="col-md-2">
                        <div class="input-group date">
                            <input id="start_date" class="form-control" type="text" name="start_date" value="{{queryStringValue('sdt')}}" placeholder="Date">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><span
                                            class="glyphicon glyphicon-calendar"></span></button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-1 control-label" for="class_entity_id">Class</label>
                    <div class="col-md-2">
                        <select id="class_entity_id" class="form-control" name="cei">
                            <option value="none">Select a class..</option>
                            @foreach($timetable->classes() as $option)
                                <option {{ activeSelect($option['class_entity_id'], 'cei') }} value="{{ $option['class_entity_id'] }}">{{ $option['class_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </form>

            <?php
                $weekDays = $timetable->weekDays();
                $periods = $timetable->periods();
                $rows = $timetable->rows();
            ?>

            @if ($timetable->isEnabled())
                <div class="row subjects-btns-row">
                    <div class="col-md-12">
                        <?php $isFirst = true; ?>
                        @foreach ($timetable->classSubject() as $subject)
                            @if (isset($subject['subject_entity_id']) && isset($subject['subject_short_code']))
                                <label class="radio-inline">
                                    <input @if($isFirst) checked="checked" @endif class="subject-radio-btn" data-shortcode="{{$subject['subject_short_code']}}" type="radio" name="class_subject" value="{{$subject['subject_entity_id']}}"> {{$subject['subject_short_code']}}
                                </label>
                            @endif
                            <?php $isFirst = false; ?>
                        @endforeach
                    </div>
                </div>
            @endif

            <table class="timetable table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="periods-th"></th>
                        @foreach ($weekDays as $day)
                            <?php $weekDayShort = isset($day['week_day_short_code']) ? $day['week_day_short_code'] : ''; ?>
                            <th class="text-center">{{$weekDayShort}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($periods as $period)
                        <?php
                            $periodName = isset($period['period_name']) ? $period['period_name'] : '';
                            $startTime = isset($period['start_time']) ? $period['start_time'] : '';
                            $endTime = isset($period['end_time']) ? $period['end_time'] : '';
                            $periodType = isset($period['period_type']) ? $period['period_type'] : '';
                            $periodId = isset($period['period_id']) ? $period['period_id'] : '';
                        ?>
                        <tr>
                            @if ($periodType == 'Break')
                                <td class="text-center period-break" colspan="{{count($weekDays)+1}}">
                                    <strong>{{$periodName}}</strong> {{hour_minutes($startTime)}} - {{hour_minutes($endTime)}}
                                </td>
                            @else
                                <td class="text-right">
                                    <strong>{{$periodName}}</strong> {{hour_minutes($startTime)}} - {{hour_minutes($endTime)}}
                                </td>
                                @foreach ($weekDays as $day)
                                    @if ($timetable->isEnabled())
                                        <?php
                                            $weekDay = isset($day['week_day']) ? $day['week_day'] : '';
                                            $weekId = isset($day['week_day_number']) ? $day['week_day_number'] : '';
                                            $subject = $timetable->findSubject($rows, $periodName, $weekDay);
                                            $shortCode = isset($subject['subject_short_code']) ? $subject['subject_short_code'] : '';
                                            $subjectId = isset($subject['subject_entity_id']) ? $subject['subject_entity_id'] : '';
                                        ?>
                                        <td class="text-center timetable-cell" data-periodid="{{$periodId}}" data-weekid="{{$weekId}}" data-subjectid="{{$subjectId}}">
                                            {{$shortCode}}
                                        </td>
                                    @else
                                        <td></td>
                                    @endif
                                @endforeach
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($timetable->isEnabled())
            <form class="form-horizontal" id="save-timetable-form" action="{{form_action_full()}}" method="POST">
                {{ csrf_field() }}

                <input type="hidden" name="weekID_periodID_subjectID" id="weekID_periodID_subjectID" value="">

                <div class="form-group">
                    <label class="col-md-2 col-md-offset-8 control-label" for="effective_start_date">Effective Start Date</label>
                    <div class="col-md-2">
                        <div class="input-group date">
                            <input id="effective_start_date" class="form-control" type="text" name="effective_start_date" value="" placeholder="Effective Start Date">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><span
                                            class="glyphicon glyphicon-calendar"></span></button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 col-md-offset-8 control-label" for="effective_end_date">Effective End Date</label>
                    <div class="col-md-2">
                        <div class="input-group date">
                            <input id="effective_end_date" class="form-control" type="text" name="effective_end_date" value="" placeholder="Effective End Date">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><span
                                            class="glyphicon glyphicon-calendar"></span></button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12">
                        <button type="submit" class="pull-right btn btn-primary">Save Timetable</button>
                    </div>
                </div>
            </form>
            @endif


            @if ($timetable->isEnabled())
                <hr/>
                <div class="row"><div class="col-md-3 pull-left"><h3 style="margin-top:0px;">Verify Time Table</h3></div></div>

                <form class="form-horizontal" action="" method="POST">
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="class_teacher">Time Table Account</label>
                        <div class="col-md-3">
                            <select id="class_teacher" class="form-control" name="cti">
                                <option value="none">Select an account..</option>
                                @foreach($timetable->timeTableFilter() as $option)
                                    <option {{ activeSelect($option['entity_id'], 'cti') }} value="{{ $option['entity_id'] }}">{{ $option['entity_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>

                @include('modules.teacher.ClassTimeTable.second-grid')

            @endif

            @include('commons.modal')

        </div>
    </div>
</div>
@endsection

@section('styles')
<style type="text/css">
    .timetable {
        table-layout: fixed;
        word-wrap: break-word;
    }
    .period-break {

    }
    .subjects-btns-row {
        margin-bottom: 10px;
    }
    .timetable-cell:hover {
        background-color: #f1f1f1;
        cursor: pointer;
    }
</style>
@endsection

@section('scripts')
<script type="text/javascript">

    $('#start_date, #class_entity_id, #class_teacher').change(function() {
        updateQueryString();
    });

    function updateQueryString() {
        window.location.href = window.location.href.split('?')[0] + getQueryString();
    }

    function getQueryString() {
        var sdt = $('#start_date').val();
        var cei = $('#class_entity_id option:selected').val();
        var cti = $('#class_teacher option:selected').val();

        var items = [];
        if (sdt != "") {
            items.push('sdt='+encodeURIComponent(sdt));
        }
        if (cei != "none") {
            items.push('cei='+cei);
        }
        if (cti != "none") {
            items.push('cti='+cti);
        }

        var queryString = items.join('&');
        if (queryString.length > 1) {
            return '?' + queryString;
        }
        return '';
    }

    @if ($timetable->isEnabled())
        $(document).ready(function() {
            $('.timetable-cell').on('click', function() {
                var subject = $('.subject-radio-btn:checked');
                var shortCode = $(subject).attr('data-shortcode');
                var subjectId = $(subject).val();

                // if you click twice on the same cell, remove the shortcode
                if ($(this).attr('data-subjectid') == subjectId) {
                    $(this).html('');
                    $(this).attr('data-subjectid', '');
                } else {
                    $(this).html(shortCode);
                    $(this).attr('data-subjectid', subjectId);
                }
            });
        });
    @endif

    // When submitting the form, prepend all selected checkboxes
    $('#save-timetable-form').submit(function() {
        if (! $('#save-timetable-form').valid()) {
            return false;
        }

        var timetableIds = [];

        $('.timetable-cell').each(function() {
            var weekId = $(this).attr('data-weekid');
            var periodId = $(this).attr('data-periodid');
            var subjectId = $(this).attr('data-subjectid');
            if (subjectId) {
                timetableIds.push(weekId+'-'+periodId+'-'+subjectId);
            }
        });

        $('#weekID_periodID_subjectID').val(timetableIds.join('|'));

        return true;
    });

    $('#save-timetable-form').validate({
        rules: {
            effective_start_date: {
                required: true,
                dateISO: true
            },
            effective_end_date: {
                required: true,
                dateISO: true
            }
        }
    });

    $('#effective_start_date, #effective_end_date').change(function() {
        $('#effective_start_date').valid();
        $('#effective_end_date').valid();
    });

</script>
@endsection
