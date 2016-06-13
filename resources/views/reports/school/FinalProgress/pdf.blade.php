<!DOCTYPE html>
<html>
    <head>
        <title>Final Progress</title>
        @include('reports.common.bootstrap')
        @include('reports.common.css')
        <style type="text/css">
            .first-td {
                min-width: 300px;
            }
            .signatures {
                margin-top:20px;
            }

            .table {
                font-size: 12px;
            }
            .table>tbody>tr>td,
            .table>tbody>tr>th,
            .table>tfoot>tr>td,
            .table>tfoot>tr>th,
            .table>thead>tr>td,
            .table>thead>tr>th {
                padding: 4px;
            }
        </style>
    </head>
    <body>

    <div id="watermark"><div id="watermark-text">{{$export->schoolName}}</div></div>

@foreach($export->students as $student)

    <?php $export->setStudentData($student); ?>

    <div class="container">

        @include('reports.common.pdf-header', [
            'school' => $export->schoolName,
            'phone'  => $export->schoolWorkPhone,
        ])

        @include('reports.common.report-name', ['report' => $export->reportName])

        <div class="row">
            <div class="col-md-12">
                <table class="header-table">
                    <tr>
                        <td class="first-td text-left"><h4>Student Name: <strong>{{$export->studentFullName}}</strong></h4></td>
                        <td class="first-td text-right"><h4>Class: <strong>{{$export->className}}</strong></h4></td>
                    </tr>
                    <tr>
                        <td class="first-td text-left"><h4>Roll No.: <strong>{{$export->studentRollNumber}}</strong></h4></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-left">Subject</th>
                            @foreach($export->exams as $exam)
                                <th class="text-left">{{$exam}}</th>
                            @endforeach
                        <th class="text-left">Final Subject Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($export->subjects as $subject)
                    <tr>
                        <td class="text-left"><strong>{{$subject['subject']}}</strong></td>
                            @foreach($export->exams as $exam)
                                <td class="text-left">
                                    @if (isset($subject[$exam]))
                                        {{$subject[$exam]}}
                                    @else
                                        -
                                    @endif
                                </td>
                            @endforeach
                        <td class="text-left">{{$subject['overall_subject_grade']}}</td>
                    </tr>
                    @endforeach

                    <tr>
                        <td class="text-left"><strong>Total</strong></td>
                            @foreach($export->exams as $exam)
                                <td class="text-left">
                                    @if (isset($export->subjectsTotal[$exam]))
                                        <strong>{{$export->subjectsTotal[$exam]}}</strong>
                                    @else
                                        -
                                    @endif
                                </td>
                            @endforeach
                        <td class="text-left">&nbsp;</td>
                    </tr>

                    <tr>
                        <td class="text-left"><strong>Grade</strong></td>
                            @foreach($export->exams as $exam)
                                <td class="text-left">
                                    @if (isset($export->subjectsGrade[$exam]))
                                        <strong>{{$export->subjectsGrade[$exam]}}</strong>
                                    @else
                                        -
                                    @endif
                                </td>
                            @endforeach
                        <td class="text-left">&nbsp;</td>
                    </tr>

                    <tr>
                        <td class="text-left"><strong>Result</strong></td>
                            @foreach($export->exams as $exam)
                                <td class="text-left">
                                    @if (isset($export->subjectsResult[$exam]))
                                        {{$export->subjectsResult[$exam]}}
                                    @else
                                        -
                                    @endif
                                </td>
                            @endforeach
                        <td class="text-left">&nbsp;</td>
                    </tr>

                </tbody>
            </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="header-table">
                    <tr>
                        <td class="text-left first-td"><h4>Overall Grade: <strong>{{$export->overallGrade}}</strong></h4></td>
                        {{-- <td class="text-right first-td"><h4>Result: <strong>-</strong></h4></td> --}}
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="header-table">
                    <tr>
                        <td class="text-left first-td"><h3><strong>Attendance</strong></h3></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
            <table class="table attendance-table table-bordered table-striped">
                <tr>
                    <td class="text-left"><strong>Name of the Month</strong></td>
                    <td class="text-left">Jun</td>
                    <td class="text-left">July</td>
                    <td class="text-left">Aug</td>
                    <td class="text-left">Sep</td>
                    <td class="text-left">Oct</td>
                    <td class="text-left">Nov</td>
                    <td class="text-left">Dec</td>
                    <td class="text-left">Jan</td>
                    <td class="text-left">Feb</td>
                    <td class="text-left">Mar</td>
                    <td class="text-left">Apr</td>
                </tr>
                <tr>
                    <td class="text-left"><strong>No. of Working Days</strong></td>
                    <td class="text-left">{{$export->workingDays('Jun')}}</td>
                    <td class="text-left">{{$export->workingDays('July')}}</td>
                    <td class="text-left">{{$export->workingDays('Aug')}}</td>
                    <td class="text-left">{{$export->workingDays('Sep')}}</td>
                    <td class="text-left">{{$export->workingDays('Oct')}}</td>
                    <td class="text-left">{{$export->workingDays('Nov')}}</td>
                    <td class="text-left">{{$export->workingDays('Dec')}}</td>
                    <td class="text-left">{{$export->workingDays('Jan')}}</td>
                    <td class="text-left">{{$export->workingDays('Feb')}}</td>
                    <td class="text-left">{{$export->workingDays('Mar')}}</td>
                    <td class="text-left">{{$export->workingDays('Apr')}}</td>
                </tr>
                <tr>
                    <td class="text-left"><strong>No. of Present Days</strong></td>
                    <td class="text-left"><strong>{{$export->presentDays('Jun')}}</strong></td>
                    <td class="text-left"><strong>{{$export->presentDays('July')}}</strong></td>
                    <td class="text-left"><strong>{{$export->presentDays('Aug')}}</strong></td>
                    <td class="text-left"><strong>{{$export->presentDays('Sep')}}</strong></td>
                    <td class="text-left"><strong>{{$export->presentDays('Oct')}}</strong></td>
                    <td class="text-left"><strong>{{$export->presentDays('Nov')}}</strong></td>
                    <td class="text-left"><strong>{{$export->presentDays('Dec')}}</strong></td>
                    <td class="text-left"><strong>{{$export->presentDays('Jan')}}</strong></td>
                    <td class="text-left"><strong>{{$export->presentDays('Feb')}}</strong></td>
                    <td class="text-left"><strong>{{$export->presentDays('Mar')}}</strong></td>
                    <td class="text-left"><strong>{{$export->presentDays('Apr')}}</strong></td>
                </tr>
            </table>
            </div>
        </div>

        <div class="row signatures">
            <div class="col-md-12">
                <table class="header-table">
                    <tr>
                        <td class="text-center"><h4><strong>Parent Signature</strong></h4></td>
                        <td class="text-center"><h4><strong>Teacher Signature</strong></h4></td>
                        <td class="text-center"><h4><strong>Principal Signature</strong></h4></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="pdf-page-break"></div>

@endforeach

    </body>
</html>
