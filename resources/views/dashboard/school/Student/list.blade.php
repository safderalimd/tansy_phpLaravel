@extends('layout.dashboard')

@section('title', 'Student Dashboard')

@section('content')

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2><div class="page-title">{{$student->info['student_full_name']}}</h2>

                <?php
                    $hasPicture = file_exists(storage_path('uploads/'. domain() . "/student-images/{$student->student_entity_id}"));
                    $columns = 'col-md-3';
                    if ($hasPicture) {
                        $columns = 'col-md-4';
                    }
                ?>

                @if ($hasPicture)
                    <div class="row">
                        <div class="col-md-12" style="text-align:center;">
                            <div class="img-thumbnail-container">
                                <div class="img-thumbnail">
                                    <span class="helper-img"></span><img src="/cabinet/img/student/{{$student->student_entity_id}}?w=260&h=260&ri=<?php echo time().uniqid(); ?>" alt="Student Image" class="">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="row">

                            @if (!$hasPicture)
                                <div class="col-md-2 placeholder text-center">
                                    <img src="/dashboard/student.jpg" class="center-block img-responsive img-circle" alt="Image">
                                    <div class="stat-panel-title text-uppercase">Student</div>
                                </div>
                            @endif

                            <div class="{{$columns}}">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-success text-light">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1">
                                                @if (!is_numeric($student->overall_grade) && empty($student->overall_grade))
                                                    &nbsp;
                                                @else
                                                    {{$student->overall_grade}}
                                                @endif
                                            </div>
                                            <div class="stat-panel-title text-uppercase">
                                               Overall Grade
                                            </div>
                                        </div>
                                    </div>
                                    <a class="block-anchor panel-footer text-center" href="/cabinet/student-dashboard/overall-grade?csi={{$student->class_student_id}}">Full Details &nbsp;<i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>

                            <div class="{{$columns}}">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-warning text-light">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1">
                                                <i class="fa fa-inr"></i> {{amount($student->feeDue)}}
                                            </div>
                                            <div class="stat-panel-title text-uppercase">
                                                Fee Due
                                            </div>
                                        </div>
                                    </div>
                                    <a class="block-anchor panel-footer text-center" href="/cabinet/student-dashboard/fee-due?sei={{$student->student_entity_id}}">Full Details &nbsp;<i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>

                            <div class="{{$columns}}">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-info text-light">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1" style="height:39px;font-size:32px;">
                                                @if (empty($student->info['mobile_phone']))
                                                    &nbsp;
                                                @else
                                                    {{phone_number_spaces($student->info['mobile_phone'])}}
                                                @endif
                                            </div>
                                            <div class="stat-panel-title text-uppercase">
                                                Mobile No
                                            </div>
                                        </div>
                                    </div>
                                    <a class="block-anchor panel-footer text-center" href="/cabinet/student-dashboard/sms-history?csi={{$student->class_student_id}}">Show History &nbsp;<i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row show-grid">
                                    <div class="col-xs-6 col-sm-6">
                                        <h2>Student</h2>
                                        <h5><br/>Name: {{$student->info['student_full_name']}}
                                        <br/><br/>Date of Birth: {{style_date($student->info['date_of_birth'])}}
                                        <br/><br/>Identification: {{$student->info['identification1']}} {{$student->info['identification2']}}
                                        </h5>
                                    </div>

                                    <div class="col-xs-6 col-sm-3">
                                        <h2>Parent</h2>
                                        <h5><br/>Name: {{$student->info['parent_full_name']}}
                                        <br/><br/>Designation: {{$student->info['parent_designation_name']}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row show-grid">
                                    <div class="col-xs-6 col-sm-6">
                                        <h5>Class:  {{$student->info['class_name']}}
                                        <br/><br/>Roll Number: {{$student->info['student_roll_number']}}
                                        <br/><br/>Admission Number: {{$student->info['admission_number']}}
                                        <br/><br/>Admission Date:  {{style_date($student->info['admission_date'])}}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row show-grid">
                                    <div class="col-xs-6 col-sm-6">
                                        <h5>Address 1:   {{$student->info['address1']}}
                                        <br/><br/>Address 2:  {{$student->info['address2']}}
                                        <br/><br/>City:  {{$student->info['city_name']}}
                                        <br/><br/>Postal:  {{$student->info['postal_code']}}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="dropdown">
                                    <label style="margin-right: 5px;"><h5>Exam performence:</h5></label>
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">{{$student->examName}}
                                    <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        @foreach($student->exams as $exam)
                                            <li><a href="/cabinet/student-dashboard?csi={{$student->class_student_id}}&sei={{$student->student_entity_id}}&eei={{$exam['exam_entity_id']}}">{{$exam['exam']}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <ul class="chart-dot-list student-exam-performance">
                                            @foreach($student->examPieChart as $row)
                                                <li class="chart-label"><span class="chart-dot-circle"></span>{{$row['label']}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="chart chart-doughnut">
                                            <canvas height="900" id="exam-report" width= "1200"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Exam Grade: {{$student->exam_grade}}</h5>
                                        <h5>Result: {{$student->exam_result}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                Fee Receipt
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="table-receipts" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Reciept #</th>
                                                <th>Paid Date</th>
                                                <th>Paid Amount</th>
                                                <th>New balence</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($student->receipts as $row)
                                            <tr>
                                                <td><a target="_blank" href="/cabinet/receipt-report/pdf/{{$row['receipt_id']}}">{{$row['receipt_number']}}</a></td>
                                                <td>{{style_date($row['receipt_date'])}}</td>
                                                <td>&#x20b9; {{amount($row['receipt_amount'])}}</td>
                                                <td>&#x20b9; {{amount($row['new_balance'])}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
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

@endsection

@section('scripts')
<script type="text/javascript">

    var pieData = <?php echo json_encode($student->examPieChart); ?>;
    pieData = applyChartColors(pieData, '.student-exam-performance');

    $(document).ready(function() {
        $('#table-receipts').DataTable({
            "autoWidth": false
        });
    });

    window.onload = function() {
        var pieContext = document.getElementById("exam-report").getContext("2d");
        window.myPie = new Chart(pieContext).Pie(pieData, {responsive : true});
    };
</script>
@endsection
