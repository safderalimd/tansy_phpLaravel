<!DOCTYPE html>
<html>
    <head>
        <title>Time Table</title>
        @include('reports.common.bootstrap')
        @include('reports.common.css')
        <style type="text/css">
        </style>
    </head>
    <body>

    <div class="container">

        <strong>

            @include('reports.common.pdf-header', [
                'school' => $export->organizationName(),
                'line2'  => $export->organizationLine2(),
                'line3'  => $export->organizationLine3(),
            ])

            @include('reports.common.report-name', ['report' => 'Time Table'])

        </strong>

        <div class="row">
            @if ($export->showType() == 'Class')
                <div class="col-md-12"><h4>Class: {{$export->dropdownFilter}} </h4></div>
            @else
                <div class="col-md-12"><h4>Teacher: {{$export->dropdownFilter}} </h4></div>
            @endif
        </div>
        <div class="row">
            <div class="col-md-12"><h4>Start Date: {{style_date($export->startDateFilter)}} </h4></div>
        </div>

        @include('reports.common.print-date-time')

        <?php
            $weekDays = $export->weekDays();
            $periods = $export->periods();
            $rows = $export->rows;
        ?>

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
                                <?php
                                    $weekDay = isset($day['week_day']) ? $day['week_day'] : '';
                                    $subject = $export->findSubject($rows, $periodName, $weekDay);
                                    $shortCode = isset($subject['subject_short_code']) ? $subject['subject_short_code'] : '';
                                    $className = isset($subject['class_name']) ? $subject['class_name'] : '';
                                ?>
                                <td class="text-center timetable-cell">
                                    @if ($export->showType() == 'Class')
                                        {{$shortCode}}
                                    @else
                                        {{$className}}
                                    @endif
                                </td>
                            @endforeach
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    </body>
</html>
