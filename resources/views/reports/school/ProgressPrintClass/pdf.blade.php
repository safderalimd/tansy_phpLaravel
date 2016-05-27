<!DOCTYPE html>
<html>
    <head>
        <title>Class Report</title>
        @include('reports.common.bootstrap')
        @include('reports.common.css')
        <style type="text/css">
            .table {
                font-size: 12px;
            }
        </style>
    </head>
    <body>

    <div class="footer text-right">
        Page: <span class="pagenum"></span>
    </div>

    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <h3 class="school-name text-center">{{$export->schoolName}}</h3>
                <h4 class="school-phone text-center">Phone No. {{phone_number_spaces($export->schoolWorkPhone)}}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h4 class="report-name text-center">{{$export->examInfo['exam']}} - {{$export->reportName}}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="header-table">
                    <tr>
                        <td class="text-left"><h4 class="">Date: {{current_date()}}</h4></td>
                        <td class="text-right"><h4 class="">Time: {{current_time()}}</h4></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="header-table">
                    <tr>
                        <td class="text-left"><h4><strong>Exam Start Date:</strong> {{$export->examInfo['exam_start_date']}}</h4></td>
                        <td class="text-right"><h4><strong>Exam End Date:</strong> {{$export->examInfo['exam_end_date']}}</h4></td>
                    </tr>
                    <tr>
                        <td class="text-left"><h4><strong>Class Name:</strong> {{$export->examInfo['class_name']}}</h4></td>
                        <td class="text-right"></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
            <table class="table table-bordered table-striped table-condensed">
                <thead>
                    <tr>
                        <th class="text-left">Student Name</th>
                        <th class="text-left">Student #</th>
                        @foreach($export->subjectList as $subject)
                            <th class="text-left">{{$subject}}</th>
                        @endforeach
                        <th class="text-left">Max Total</th>
                        <th class="text-left">Student Total</th>
                        <th class="text-left">Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($export->studentRows as $row)
                    <tr>
                        <td class="text-left">{{$row['student_full_name']}}</td>
                        <td class="text-left">{{$row['student_roll_number']}}</td>
                        @foreach($export->subjectList as $subject)
                            <td class="text-left">
                                @if (isset($row[$subject]))
                                    {{$row[$subject]}}
                                @else
                                    -
                                @endif
                            </td>
                        @endforeach
                        <td class="text-left">{{$row['max_total_marks']}}</td>
                        <td class="text-left">{{$row['student_total_marks']}}</td>
                        <td class="text-left">{{$row['grade']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>

    </div>
    </body>
</html>
