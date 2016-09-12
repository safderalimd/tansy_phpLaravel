<?php $teacherRows = $timetable->teacherRows(); ?>
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
                        @if (count($teacherRows))
                            <?php
                                $weekDay = isset($day['week_day']) ? $day['week_day'] : '';
                                $subject = $timetable->findSubject($teacherRows, $periodName, $weekDay);
                                $className = isset($subject['class_name']) ? $subject['class_name'] : '';
                            ?>
                            <td class="text-center verify-timetable-cell">
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
