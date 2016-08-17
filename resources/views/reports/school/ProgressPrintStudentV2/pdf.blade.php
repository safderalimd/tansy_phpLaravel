<!DOCTYPE html>
<html>
    <head>
        <title>Student Report</title>
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
            .school-title {
                position: absolute;
                left: 7px;
            }
            .exam-name {
                text-align: center;
            }
            .exam-name div {
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
                width: 70px;
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
        </style>
    </head>
    <body>

    <div id="watermark"><div id="watermark-text">{{$progress->organizationName}}</div></div>

@foreach($progress->students as $student)

    <?php
        $studentTotals = $progress->getTotal($student);

        $firstItem = $student->first();
        $studentId = isset($firstItem['student_entity_id']) ? $firstItem['student_entity_id'] : null;
        $studentName = isset($firstItem['student_full_name']) ? $firstItem['student_full_name'] : null;
        $rollNr = isset($firstItem['student_roll_number']) ? $firstItem['student_roll_number'] : null;
    ?>
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading top-panel">
                        <div class="school-title">{{$progress->organizationName}}</div>
                        <div class="exam-name">
                            <div>{{$progress->examName}}</div>
                            <div>Result Sheet</div>
                        </div>
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
                                                    <th>{{$type}} <br/>5</th>
                                                @endforeach
                                                <th class="th-total">Total <br/>20</th>
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
                                                <td class="cell-remarks" rowspan="3" colspan="4">Remarks</td>
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
                                                    Class II <br/>
                                                    Roll No. {{$rollNr}} <br/>
                                                    Admn.No. 12 <br/>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <table class="table table-bordered attendance-row">
                                                    <tr>
                                                        <th colspan="3" class="attendance-header-text">Attendance Details</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Month</th>
                                                        <th>Working Days</th>
                                                        <th>Days Present</th>
                                                    </tr>
                                                    <tr>
                                                        <th>June</th>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>July</th>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <table class="table table-bordered signatures-row">
                                                    <tr>
                                                        <th class="gray-bg">Class Teacher Signature</th>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Headmaster Signature</th>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="gray-bg">Parent Signature</th>
                                                        <td></td>
                                                    </tr>
                                                </table>
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

    </div>

    <div class="pdf-page-break"></div>

@endforeach

    </body>
</html>
