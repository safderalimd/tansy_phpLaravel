<!DOCTYPE html>
<html>
    <head>
        <title>Progress Report</title>
        @include('reports.common.bootstrap')
        @include('reports.common.css')
        <style type="text/css">
            .panel {
                margin-top: 10px;
                border-radius: 0px;
            }
            .panel-heading {
                text-align: center;
                text-transform: uppercase;
                font-size: 16px;
                line-height: 16px;
                font-weight: bold;
            }
            .panel-body {
                padding: 10px 5px;
            }

            .top-panel {
                position: relative;
            }
            .top-panel div {
                text-align: center;
            }
            .marks-grid {
                padding: 0px;
            }
            .marks-grid td,
            .marks-grid th {
                text-align: center;
                vertical-align: middle !important;
            }
            .th-total,
            .subject-grade-point {
                min-width: 70px;
            }
            .table {
                margin-bottom: 0px;
            }

            .marks-grid td.cell-remarks {
                text-decoration: underline;
                vertical-align: top !important;
            }
            .cell-remarks,
            .cell-grand-total,
            .cell-gpa,
            .cell-percentage,
            .cell-grade {
                text-transform: uppercase;
                font-weight: bold;
                background-color: #fff;
            }

            .cell-gpa {
                background-color: #f3f3f3;
            }

            .student-picture img {
                max-width: 100px;
                max-height: 100px;
            }
            .student-info {
                text-transform: uppercase;
                text-decoration: underline;
                font-weight: bold;
            }

            .signatures-row td,
            .signatures-row th,
            .attendance-row td,
            .attendance-row th {
                vertical-align: middle !important;
                text-align: center;
            }
            .attendance-header-text {
                text-transform: uppercase;
                font-weight: bold;
                border-top: 1px solid #ddd;
                border-left: 1px solid #ddd;
                border-right: 1px solid #ddd;
                border-bottom: 0px;
                border-radius: 0px;
                background-color: #f9f9f9;
            }

            .signatures-row,
            .attendance-row {
                margin: 10px 0px 0px 0px;
                table-layout: fixed;
            }
            .gray-bg {
                background-color: #f9f9f9;
            }

            .marks-grid,
            .right-grid {
                border-top: 0px !important;
                padding: 0px !important;
            }

            .marks-grid {
                padding-right: 10px !important;
            }
            .right-grid {
                width: 250px;
            }

            .school-title {
                font-size: 18px;
            }
            .phone-number {
                font-size: 14px;
            }

            #school-logo-wrapper {
                position: fixed;
                bottom: 0px;
                right: 0px;
                width: 100%;
                height: 100%;
                opacity: .2;
                z-index: 2;
                text-align: center;
            }
            #school-img-center {
                height: 200px;
                width: 200px;
                position: relative;
                top: 50%;
                margin: -100px auto 0 auto;
                text-align: center;
            }
            .attendance-row {
                font-size: 14px;
            }
            .header-table {
                table-layout: fixed;
            }

            .marks-grid table,
            .marks-grid td,
            .marks-grid th,
            .marks-grid tr,
            .marks-grid div {
                font-size: 10px;
            }

            .page-wrapper {
                height: 100vh;
            }
            @media print
            {
                @page
                {
                    size: landscape;
                }
            }

        </style>
    </head>
    <body>

<?php
    $nrOfStudents = count($progress->students);
    $currentStudent = 0;
    $index = 0;
?>
@foreach($progress->students as $student)
    <?php
        $currentStudent++;
        $studentTotals = $progress->getTotal($student);

        $firstItem = $student->first();
        $studentId = isset($firstItem['student_entity_id']) ? $firstItem['student_entity_id'] : null;
        $classStudentId = isset($firstItem['class_student_id']) ? $firstItem['class_student_id'] : null;

        $studentName = isset($firstItem['student_full_name']) ? $firstItem['student_full_name'] : null;
        $rollNr = isset($firstItem['student_roll_number']) ? $firstItem['student_roll_number'] : null;

        $className = isset($firstItem['class_name']) ? $firstItem['class_name'] : null;
        $admissionNr = isset($firstItem['admission_number']) ? $firstItem['admission_number'] : null;

        $subjectMaxTotal = isset($firstItem['subject_max_total']) ? $firstItem['subject_max_total'] : null;
    ?>

    <div class="page-wrapper">
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading top-panel">
                        <div class="school-title">{{$progress->organizationName}}</div>
                        <div class="phone-number">{{phone_number($progress->mobilePhone)}}</div>
                        <div>&nbsp;</div>
                        <div class="exam-name">{{$progress->examName}}</div>
                        <div>Result Sheet</div>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <td class="marks-grid">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Subject</th>
                                                @foreach($progress->examTypes as $type)
                                                    <th>{{$type}}</th>
                                                @endforeach
                                                <th class="th-total">Total <br/>({{$subjectMaxTotal}})</th>
                                                <th class="subject-grade-point">Subject Grade Point</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($student as $subject)
                                                <tr>
                                                    <th>
                                                        @if (isset($subject['subject_name']))
                                                            {{$subject['subject_name']}}
                                                        @endif
                                                    </th>

                                                    @foreach($progress->examTypes as $type)
                                                        <td>
                                                            @if (isset($subject[$type]))
                                                                {{$subject[$type]}}
                                                            @else
                                                                AB
                                                            @endif
                                                        </td>
                                                    @endforeach

                                                    <td>
                                                        @if (isset($subject['student_subject_max_total']))
                                                            {{$subject['student_subject_max_total']}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (isset($subject['subject_gpa']))
                                                            {{$subject['subject_gpa']}}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach

                                            <tr>
                                                <?php
                                                    $colspan = count($progress->examTypes);
                                                ?>
                                                <td class="cell-remarks" rowspan="3" colspan="{{$colspan}}">Remarks</td>
                                                <td class="cell-grand-total">Grand Total</td>
                                                <td>
                                                    @if (isset($studentTotals['student_total_marks']))
                                                        {{$studentTotals['student_total_marks']}}
                                                    @endif
                                                </td>
                                                <td class="cell-gpa">GPA</td>
                                            </tr>
                                            <tr>
                                                <td class="cell-percentage">Percentage</td>
                                                <td>
                                                    @if (isset($studentTotals['score_percent']))
                                                        {{$studentTotals['score_percent']}}
                                                    @endif
                                                </td>
                                                <td class="cell-gpa" rowspan="2">
                                                    @if (isset($studentTotals['gpa']))
                                                        {{$studentTotals['gpa']}}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="cell-grade">Grade</td>
                                                <td>
                                                    @if (isset($studentTotals['grade']))
                                                        {{$studentTotals['grade']}}
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td class="right-grid">

                                    <table>
                                        <tr>
                                            <td>
                                                <div class="student-picture">
                                                    <img src="{{student_picture($studentId)}}" class="" alt="Image">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="student-info">
                                                    {{$studentName}} <br/>
                                                    {{$className}} <br/>
                                                    Roll No. {{$rollNr}} <br/>
                                                    Admn.No. {{$admissionNr}} <br/>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <canvas id="bar-chart{{$index}}" width="230" height="150"></canvas>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <strong>Attendance Details</strong><br/>
                                                <?php
                                                    $months = $progress->attendance->where('class_student_id', $classStudentId);
                                                ?>

                                                @foreach ($months as $month)
                                                    <?php
                                                        $calendarMonth = isset($month['calendar_month']) ? $month['calendar_month'] : '';
                                                        $workingDays = isset($month['working_days']) ? $month['working_days'] : '';
                                                        $presentDays = isset($month['present_days']) ? $month['present_days'] : '';
                                                    ?>
                                                    {{$calendarMonth}} {{$presentDays}}/{{$workingDays}}<br/>
                                                @endforeach
                                            </td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                        </table>

                    </div>
                </div>
            </div>
        </div>

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

    {{-- Don't add page break after last student --}}
    @if ($currentStudent < $nrOfStudents)
        <div class="pdf-page-break"></div>
    @endif

    </div>

    <script type="text/javascript">
        var labels;
        var percentages;
    </script>
    <?php
        $chartSubjects = [];
        $chartPercentages = [];
        $chartPercentagesLine = [];
        foreach ($student as $subject) {
            $chartSubjects[] = isset($subject['subject_short_code']) ? $subject['subject_short_code'] : '';
            $chartPercentages[] = isset($subject['student_subject_percent']) ? $subject['student_subject_percent'] : '';
            $chartPercentagesLine[] = isset($subject['student_previous_subject_percent']) ? $subject['student_previous_subject_percent'] : '';
        }
    ?>
    <script type="text/javascript">
        labels = <?php echo json_encode($chartSubjects); ?>;
        percentages = <?php echo json_encode($chartPercentages); ?>;

        var data{{$index}} = {
            labels: labels,
            datasets: [
                {
                    label: "Results",
                    fillColor: "rgba(0,69,168,0.5)",
                    strokeColor: "rgba(220,220,220,0.8)",
                    highlightFill: "rgba(220,220,220,0.75)",
                    highlightStroke: "rgba(220,220,220,1)",
                    data: percentages
                }
            ]
        };

    </script>

    <?php $index++; ?>
@endforeach


    <script src="/js/app.js"></script>
    <script src="/dashboard/Chart.min.js"></script>
    <script type="text/javascript">
        var options = {
            scaleOverride : true,
            scaleSteps : 5,
            scaleStepWidth : 20,
            scaleStartValue : 0
        }

        window.onload = function() {
            @for ($j = 0; $j<$index; $j++)
                var context{{$j}} = document.getElementById("bar-chart{{$j}}").getContext("2d");
                window.barChart{{$j}} = new Chart(context{{$j}}).Bar(data{{$j}}, options);
            @endfor
        }

    </script>
    </body>
</html>
