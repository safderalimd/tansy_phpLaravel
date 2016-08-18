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

    <div id="watermark"><div id="watermark-text">{{$progress->organizationName}}</div></div>

@foreach($progress->students as $student)

    <?php
        $studentTotals = $progress->getTotal($student);

        $firstItem = $student->first();
        $studentName = isset($firstItem['student_full_name']) ? $firstItem['student_full_name'] : null;
        $rollNr = isset($firstItem['student_roll_number']) ? $firstItem['student_roll_number'] : null;
        $className = isset($firstItem['class_name']) ? $firstItem['class_name'] : null;
    ?>

    <div class="container">

        @include('reports.common.pdf-header', [
            'school' => $progress->organizationName,
            'phone'  => $progress->mobilePhone,
        ])

        <div class="row">
            <div class="col-md-12"><h4 class="report-name text-center"><strong>Progress Report - {{$progress->examName}}</strong></h4></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="header-table">
                    <tr>
                        <td class="first-td text-left"><h4>Student Name: <strong>{{$studentName}}</strong></h4></td>
                    </tr>
                    <tr>
                        <td class="first-td text-left"><h4>Class: <strong>{{$className}}</strong></h4></td>
                    </tr>
                    <tr>
                        <td class="text-left"><h4>Roll No.: <strong>{{$rollNr}}</strong></h4></td>
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
                        <th class="text-left">GPA</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($student as $subject)
                    <tr>
                        <td class="text-left">
                            @if (isset($subject['subject_name']))
                                {{$subject['subject_name']}}
                            @endif
                        </td>
                        <td class="text-left">
                            @if (isset($subject['subject_max_total']))
                                {{marks($subject['subject_max_total'])}}
                            @endif
                        </td>
                        <td class="text-left">
                            @if (isset($subject['student_subject_max_total']))
                                {{marks($subject['student_subject_max_total'])}}
                            @endif
                        </td>
                        <td class="text-left">
                            @if (isset($subject['subject_gpa']))
                                {{$subject['subject_gpa']}}
                            @endif
                        </td>
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
                        <td class="text-left first-td">
                            <h4>Max Total: <strong>
                            @if (isset($studentTotals['max_total_marks']))
                                {{marks($studentTotals['max_total_marks'])}}
                            @endif
                            </strong></h4>
                        </td>
                        <td class="text-left">
                            <h4>Student Total: <strong>
                            @if (isset($studentTotals['student_total_marks']))
                                {{marks($studentTotals['student_total_marks'])}}
                            @endif
                            </strong></h4>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left first-td">
                            <h4>Percentage: <strong>
                            @if (isset($studentTotals['score_percent']))
                                {{marks($studentTotals['score_percent'])}}
                            @endif
                            </h4>
                        </td>
                        <td class="text-left">
                            <h4>Grade: <strong>
                            @if (isset($studentTotals['grade']))
                                {{$studentTotals['grade']}}
                            @endif
                            </strong></h4>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="header-table">
                    <tr>
                        <td class="text-left">
                            <h4>GPA: <strong>
                            @if (isset($studentTotals['gpa']))
                                {{$studentTotals['gpa']}}
                            @endif
                            </strong></h4>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <br/>
        <br/>

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
