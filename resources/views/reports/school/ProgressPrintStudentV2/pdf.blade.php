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
                padding: 10px 20px;
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

            .marks-grid,
            .right-grid {
                height: 700px;
            }
            .student-picture-row {
                height: 150px;
            }
            .attendance-row,
            .attendance-column {
                height: 265px;
            }
            .signatures-row,
            .signatures-column {
                height: 265px;
            }
            .signatures-row {
                margin-top: 20px;
            }

            .marks-grid {
                padding: 0px;
            }
            .marks-grid table {
                height: 100%;
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

            .student-picture {
                width: 120px;
                height: 120px;
                margin: 10px auto 0px auto;
            }
            .student-info {
                margin-top: 25px;
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

            .signatures-row table,
            .attendance-row table {
                height: 100%;
                margin: 0px;
                table-layout: fixed;
            }
            .gray-bg {
                background-color: #f9f9f9;
            }

            .student-info-column,
            .signatures-column,
            .attendance-column {
                padding-right: 0px;
            }
        </style>
    </head>
    <body>

    {{-- <div id="watermark"><div id="watermark-text">{{$export->schoolName}}</div></div> --}}

{{-- foreach($export->studentRows as $row) --}}

    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading top-panel">
                        <div class="school-title">Kinderland</div>
                        <div class="exam-name">
                            <div>Formative Assesement - I</div>
                            <div>Result Sheet</div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-8 marks-grid">

                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Subject</th>
                                            <th>Reading & Reflection <br/>5</th>
                                            <th>Wrtiging Work <br/>5</th>
                                            <th>Project Work <br/>5</th>
                                            <th>Written Test <br/>5</th>
                                            <th class="th-total">Total  <br/>20</th>
                                            <th class="subject-grade-point">Subject Grade Point</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>Telugu</th><td></td><td></td><td></td><td></td><td></td><td></td>
                                        </tr>
                                        <tr>
                                            <th>Hindi</th><td></td><td></td><td></td><td></td><td></td><td></td>
                                        </tr>
                                        <tr>
                                            <th>English</th><td></td><td></td><td></td><td></td><td></td><td></td>
                                        </tr>
                                        <tr>
                                            <th>Mathematics</th><td></td><td></td><td></td><td></td><td></td><td></td>
                                        </tr>
                                        <tr>
                                            <th>Gen. Science</th><td></td><td></td><td></td><td></td><td></td><td></td>
                                        </tr>
                                        <tr>
                                            <th>Social Studies</th><td></td><td></td><td></td><td></td><td></td><td></td>
                                        </tr>
                                        <tr>
                                            <td class="cell-remarks" rowspan="3" colspan="4">Remarks</td>
                                            <td class="cell-grand-total">Grand Total</td>
                                            <td></td>
                                            <td class="cell-gpa">GPA</td>
                                        </tr>
                                        <tr>
                                            <td class="cell-percentage">Percentage</td>
                                            <td></td>
                                            <td class="cell-gpa" rowspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td class="cell-grade">Grade</td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <div class="col-md-4 right-grid">
                                <div class="row student-picture-row">
                                    <div class="col-md-5">
                                        <div class="student-picture">
                                            <img src="{{student_picture(55)}}" class="center-block img-responsive" alt="Image">
                                        </div>
                                    </div>
                                    <div class="col-md-7 student-info-column">
                                        <div class="student-info">
                                            B. Charkovsky Reddy <br/>
                                            Class II <br/>
                                            Roll No. 1 <br/>
                                            Admn.No. 12 <br/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row attendance-row">
                                    <div class="col-md-12 attendance-column">
                                        <table class="table table-bordered">
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
                                    </div>
                                </div>

                                <div class="row signatures-row">
                                    <div class="col-md-12 signatures-column">
                                        <table class="table table-bordered">
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
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- <div class="pdf-page-break"></div> --}}

{{-- endforeach --}}

    </body>
</html>
