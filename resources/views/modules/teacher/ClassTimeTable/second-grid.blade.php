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
                $periodId = isset($period['period_id']) ? $period['period_id'] : '';
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
                                $weekId = isset($day['week_day_number']) ? $day['week_day_number'] : '';
                                $subject = $timetable->findSubject($rows, $periodName, $weekDay);
                                $shortCode = isset($subject['subject_short_code']) ? $subject['subject_short_code'] : '';
                                $subjectId = isset($subject['subject_entity_id']) ? $subject['subject_entity_id'] : '';
                                $className = isset($subject['class_name']) ? $subject['class_name'] : '';
                            ?>
                            <td class="verify-timetable-cell" data-periodid="{{$periodId}}" data-weekid="{{$weekId}}" data-subjectid="{{$subjectId}}">
                                {{$className}}
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
