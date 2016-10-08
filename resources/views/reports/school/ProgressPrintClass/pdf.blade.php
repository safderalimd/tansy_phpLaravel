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

    <div id="watermark"><div id="watermark-text">{{$export->schoolName}}</div></div>

    <div class="footer text-right">
        Page: <span class="pagenum"></span>
    </div>

    <div class="container">

        @include('reports.common.pdf-header', [
            'school' => $export->organizationName(),
            'line2'  => $export->organizationLine2(),
            'line3'  => $export->organizationLine3(),
        ])

        <div class="row">
            <div class="col-md-12">
                <h4 class="report-name text-center">{{$progress->examName}} - Progress Report</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="header-table">
                    <tr>
                        <td class="text-left"><h4 class="">Print Date: {{current_date()}}</h4></td>
                        <td class="text-right"><h4 class="">Print Time: {{current_time()}}</h4></td>
                    </tr>
                </table>
            </div>
        </div>

        <?php
            $allSubjects = $progress->getAllSubjects();

            $firstStudent = $progress->students->first();
            $firstStudentTotals = $progress->getTotal($firstStudent);
            $firstItem = $firstStudent->first();

            $className = isset($firstItem['class_name']) ? $firstItem['class_name'] : null;
            $maxTotalMarks = isset($firstStudentTotals['max_total_marks']) ? $firstStudentTotals['max_total_marks'] : null;
        ?>

        <div class="row">
            <div class="col-md-12">
                <table class="header-table">
{{--
                    <tr>
                        <td class="text-left"><h4><strong>Exam Start Date:</strong> {style_date($export->examInfo['exam_start_date'])}</h4></td>
                        <td class="text-right"><h4><strong>Exam End Date:</strong> {style_date($export->examInfo['exam_end_date'])}</h4></td>
                    </tr>
 --}}
                    <tr>
                        <td class="text-left"><h4><strong>Class Name:</strong> {{$className}}</h4></td>
                        <td class="text-right"><h4><strong>Max Marks:</strong> {{$maxTotalMarks}}</h4></td>
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
                        @foreach($allSubjects as $subject)
                            <th class="text-left">{{$subject}}</th>
                        @endforeach
                        <th class="text-left">Total</th>
                        <th class="text-left">Grade</th>
                        <th class="text-left">Percentage</th>
                        <th class="text-left">GPA</th>
                        <th class="text-left">Result</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($progress->students as $student)
                    <?php
                        $studentTotals = $progress->getTotal($student);

                        $firstItem = $student->first();
                        $studentName = isset($firstItem['student_full_name']) ? $firstItem['student_full_name'] : null;
                        $rollNr = isset($firstItem['student_roll_number']) ? $firstItem['student_roll_number'] : null;
                    ?>
                    <tr>
                        <td class="text-left">{{$studentName}}</td>
                        <td class="text-left">{{$rollNr}}</td>
                        @foreach($allSubjects as $oneSubject)
                            <td class="text-left">
                                <?php
                                    $subject = $student->where('subject_name', $oneSubject)->first();
                                ?>
                                @if (isset($subject['student_subject_max_total']))
                                    {{marks($subject['student_subject_max_total'])}}
                                @else
                                    -
                                @endif
                            </td>
                        @endforeach
                        <td class="text-left">
                            @if (isset($studentTotals['student_total_marks']))
                                {{marks($studentTotals['student_total_marks'])}}
                            @endif
                        </td>
                        <td class="text-left">
                            @if (isset($studentTotals['grade']))
                                {{$studentTotals['grade']}}
                            @endif
                        </td>
                        <td class="text-left">
                            @if (isset($studentTotals['score_percent']))
                                {{$studentTotals['score_percent']}}
                            @endif
                        </td>
                        <td class="text-left">
                            @if (isset($studentTotals['gpa']))
                                {{$studentTotals['gpa']}}
                            @endif
                        </td>
                        <td class="text-left">
                            @if (isset($studentTotals['pass_fail']))
                                {{$studentTotals['pass_fail']}}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>

    </div>
    </body>
</html>
