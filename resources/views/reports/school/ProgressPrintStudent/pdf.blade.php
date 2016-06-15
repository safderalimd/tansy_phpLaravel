<!DOCTYPE html>
<html>
    <head>
        <title>Student Report</title>
        @include('reports.common.bootstrap')
        @include('reports.common.css')
        <style type="text/css">
            .first-td {
                min-width: 300px;
            }
            .signatures {
                margin-top:20px;
            }
        </style>
    </head>
    <body>

    <div id="watermark"><div id="watermark-text">{{$export->schoolName}}</div></div>

@foreach($export->studentRows as $row)
    <div class="container">


        @include('reports.common.pdf-header', [
            'school' => $export->schoolName,
            'phone'  => $export->schoolWorkPhone,
        ])

        <div class="row">
            <div class="col-md-12"><h4 class="report-name text-center"><strong>{{$export->reportName}} - {{$export->examName}}</strong></h4></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="header-table">
                    <tr>
                        <td class="first-td text-left"><h4>Student Name: <strong>{{$row['student_full_name']}}</strong></h4></td>
                    </tr>
                    <tr>
                        <td class="first-td text-left"><h4>Class: <strong>{{$row['class_name']}}</strong></h4></td>
                    </tr>
                    <tr>
                        <td class="text-left"><h4>Roll No.: <strong>{{$row['student_roll_number']}}</strong></h4></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-left">Subjects</th>
                        <th class="text-left">Max Marks</th>
                        <th class="text-left">Obtain Marks</th>
                        <th class="text-left">Pass/Fail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $subjects = $export->studentDetails($row['class_student_id']);
                    ?>

                    @foreach($subjects as $subject)
                    <tr>
                        <td class="text-left">{{$subject['subject']}}</td>
                        <td class="text-left">{{marks($subject['max_marks'])}}</td>
                        <td class="text-left">{{marks($subject['student_marks'])}}</td>
                        <td class="text-left">{{$subject['pass_fail']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="header-table">
                    <tr>
                        <td class="text-left first-td"><h4>Max Total: <strong>{{marks($row['max_total_marks'])}}</strong></h4></td>
                        <td class="text-left"><h4>Student Total: <strong>{{marks($row['student_total_marks'])}}</strong></h4></td>
                    </tr>
                    <tr>
                        <td class="text-left first-td"><h4>Percentage: <strong>{{$row['score_percent']}}</strong></h4></td>
                        <td class="text-left"><h4>Grade: <strong>{{$row['grade']}}</strong></h4></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="header-table">
                    <tr>
                        <td class="text-left"><h4>Results: <strong>{{$row['pass_fail']}}</strong></h4></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row signatures">
            <div class="col-md-12">
                <table class="header-table">
                    <tr>
                        <td class="text-center"><h4><strong>Principal Signature</strong></h4></td>
                        <td class="text-center"><h4><strong>Teacher Signature</strong></h4></td>
                        <td class="text-center"><h4><strong>Parent Signature</strong></h4></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="pdf-page-break"></div>

@endforeach

    </body>
</html>
