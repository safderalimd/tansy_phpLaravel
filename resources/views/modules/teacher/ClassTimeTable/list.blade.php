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
                <div class="row subjects-radio-btns">
                    <div class="col-md-12">
                        <?php $isFirst = true; ?>
                        @foreach ($timetable->classSubject() as $subject)
                            @if (isset($subject['subject_entity_id']) && isset($subject['subject']))
                                <label class="radio-inline">
                                    <input @if($isFirst) checked="checked" @endif type="radio" name="class_subject" value="{{$subject['subject_entity_id']}}"> {{$subject['subject']}}
                                </label>
                            @endif
                            <?php $isFirst = false; ?>
                        @endforeach
                    </div>
                </div>
            @endif

            <table class="timetable table table-condensed table-striped table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        @foreach ($weekDays as $day)
                            <?php $weekDay = isset($day['week_day']) ? $day['week_day'] : ''; ?>
                            <th>{{$weekDay}}</th>
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
                        ?>
                        <tr>
                            <td>
                                <strong>{{$periodName}}</strong> <br/>
                                {{$startTime}} - {{$endTime}}
                            </td>
                            @if ($periodType == 'Break')
                                <td class="period-break" colspan="{{count($weekDays)}}"></td>
                            @else
                                @foreach ($weekDays as $day)
                                    @if ($timetable->isEnabled())
                                        <?php
                                            $weekDay = isset($day['week_day']) ? $day['week_day'] : '';
                                            $subject = $timetable->findSubject($rows, $periodName, $weekDay);
                                            $shortCode = isset($subject['subject_short_code']) ? $subject['subject_short_code'] : '';
                                        ?>
                                        <td>
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
    .subjects-radio-btns {
        margin-bottom: 10px;
    }
</style>
@endsection

@section('scripts')
<script type="text/javascript">

    $('#start_date, #class_entity_id').change(function() {
        updateQueryString();
    });

    function updateQueryString() {
        window.location.href = window.location.href.split('?')[0] + getQueryString();
    }

    function getQueryString() {
        var sdt = $('#start_date').val();
        var cei = $('#class_entity_id option:selected').val();

        var items = [];
        if (sdt != "") {
            items.push('sdt='+encodeURIComponent(sdt));
        }
        if (cei != "none") {
            items.push('cei='+cei);
        }

        var queryString = items.join('&');
        if (queryString.length > 1) {
            return '?' + queryString;
        }
        return '';
    }

</script>
@endsection
