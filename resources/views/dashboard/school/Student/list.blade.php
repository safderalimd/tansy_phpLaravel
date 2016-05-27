@extends('layout.dashboard')

@section('title', 'Student Dashboard')

@section('content')

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2><div class="page-title">{{$student->info['student_full_name']}}</h2>

                <div class="row">
                    <div class="col-md-12">
                        <div class="row">

                        <div class="col-md-2 placeholder text-center">
                            <img src="/dashboard/student.jpg" class="center-block img-responsive img-circle" alt="Image">
                            <div class="stat-panel-title text-uppercase">Student</div>
                        </div>

                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-success text-light">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1">
                                                {{$student->overall_grade}}
                                            </div>
                                            <div class="stat-panel-title text-uppercase">
                                               Overall Grade
                                            </div>
                                        </div>
                                    </div>
                                    <a class="block-anchor panel-footer text-center" href="/cabinet/student-dashboard/overall-grade?csi={{$student->student_entity_id}}">Full Details &nbsp;<i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>

                            <div class="col-md-3">
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

                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-info text-light">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1">
                                                {{phone_number_spaces($student->info['mobile_phone'])}}
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
                                        <br/><br/>Date of Birth: {{$student->info['date_of_birth']}}
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
                                        <br/><br/>Admission Date:  {{$student->info['admission_date']}}
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
                                        <ul class="chart-dot-list">
                                            <?php $i=1; ?>
                                            @foreach($student->examPieChart as $row)
                                                <li class="a{{$i++}}">{{$row['label']}}</li>
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
                                                <td>{{$row['receipt_date']}}</td>
                                                <td>{{amount($row['receipt_amount'])}}</td>
                                                <td>{{amount($row['new_balance'])}}</td>
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
    pieData = applyChartColors(pieData);

    $(document).ready(function() {
        $('#table-receipts').DataTable();
    });

    window.onload = function() {
        var pieContext = document.getElementById("exam-report").getContext("2d");
        window.myPie = new Chart(pieContext).Pie(pieData, {responsive : true});
    };
</script>
@endsection
