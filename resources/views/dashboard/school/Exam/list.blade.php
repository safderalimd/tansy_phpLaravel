@extends('layout.dashboard')

@section('title', 'Exam Dashboard')

@section('content')

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-title">
                    <h2>Exam Dashboard</h2>
                    <h4>
                        @foreach($exam->examWithResult() as $row)
                            <a class="{{activeExam($row['exam_entity_id'],'eei')}}" href="/cabinet/exam-dashboard?eei={{$row['exam_entity_id']}}">{{$row['exam']}}</a> &nbsp; &nbsp;
                        @endforeach
                    </h4>
                </div>

                @if (!empty($exam->examId))

                <div class="row">
                    <div class="col-md-12">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-info text-light">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1">
                                                {{nr($exam->toppers_count)}}
                                            </div>
                                            <div class="stat-panel-title text-uppercase">
                                               Toppers
                                            </div>
                                        </div>
                                    </div>
                                    <a class="block-anchor panel-footer text-center" href="/cabinet/exam-dashboard/toppers?eei={{$exam->exam_entity_id}}">Full Details &nbsp;<i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-danger text-light">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1">
                                                {{nr($exam->failed_students)}}
                                            </div>
                                            <div class="stat-panel-title text-uppercase">
                                                Failed Students
                                            </div>
                                        </div>
                                    </div>
                                    <a class="block-anchor panel-footer text-center" href="/cabinet/exam-dashboard/failed-students?eei={{$exam->exam_entity_id}}">Full Details &nbsp;<i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-warning text-light">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1">
                                                {{nr($exam->absentee_students)}}
                                            </div>
                                            <div class="stat-panel-title text-uppercase">
                                                Absentees
                                            </div>
                                        </div>
                                    </div>
                                    <a class="block-anchor panel-footer text-center" href="/cabinet/exam-dashboard/absentees?eei={{$exam->exam_entity_id}}">Full Details &nbsp;<i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-success text-light">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1">
                                                {{$exam->pass_percentage}} %
                                            </div>
                                            <div class="stat-panel-title text-uppercase">
                                                Pass Percentage
                                            </div>
                                        </div>
                                    </div>
                                    <a class="block-anchor panel-footer text-center" href="#">&nbsp;</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                School Performance
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <ul class="chart-dot-list">
                                            <?php $i=1; ?>
                                            @foreach($exam->subjectPerformanceDetailsChart as $row)
                                                <li class="a{{$i++}}">{{$row['label']}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="chart chart-doughnut">
                                            <canvas height="900" id="exam-report-1" width= "1200"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                School Subject Performance
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <ul class="chart-dot-list">
                                            <?php $i=1; ?>
                                            @foreach($exam->examDonoughtChart as $row)
                                                <li class="a{{$i++}}">{{$row['label']}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="chart chart-doughnut">
                                            <canvas height="900" id="exam-report-2" width= "1200"></canvas>
                                        </div>
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
                                    <label style="margin-right: 5px;"><h5>Class Performance:</h5></label>
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">{{$exam->className}}
                                    <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        @foreach($exam->classess as $row)
                                            <li><a href="/cabinet/exam-dashboard?eei={{$exam->exam_entity_id}}&cei={{$row['class_entity_id']}}">{{$row['class_name']}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <ul class="chart-dot-list">
                                            <?php $i=1; ?>
                                            @foreach($exam->classPerformancePieChart as $row)
                                                <li class="a{{$i++}}">{{$row['label']}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="chart chart-doughnut">
                                            <canvas height="900" id="subject-report" width= "1200"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h5>Class Subject Performance</h5>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <ul class="chart-dot-list">
                                            <?php $i=1; ?>
                                            @foreach($exam->classSubjectPerformancePieChart as $row)
                                                <li class="a{{$i++}}">{{$row['label']}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="chart chart-doughnut">
                                            <canvas height="900" id="class-subject-report" width= "1200"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                @endif

            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

@if (!empty($exam->examId))
<script type="text/javascript">

    var donoughtData1 = <?php echo json_encode($exam->subjectPerformanceDetailsChart); ?>;
    donoughtData1 = applyChartColors(donoughtData1);

    var donoughtData2 = <?php echo json_encode($exam->examDonoughtChart); ?>;
    donoughtData2 = applyChartColors(donoughtData2);

    var pieData = <?php echo json_encode($exam->classPerformancePieChart); ?>;
    pieData = applyChartColors(pieData);

    var pieData2 = <?php echo json_encode($exam->classSubjectPerformancePieChart); ?>;
    pieData2 = applyChartColors(pieData2);

    window.onload = function() {
        var doughnutContext1 = document.getElementById("exam-report-1").getContext("2d");
        window.myDoughnut1 = new Chart(doughnutContext1).Doughnut(donoughtData1, {responsive : true});

        var doughnutContext2 = document.getElementById("exam-report-2").getContext("2d");
        window.myDoughnut2 = new Chart(doughnutContext2).Doughnut(donoughtData2, {responsive : true});

        var pieContext = document.getElementById("subject-report").getContext("2d");
        window.myPie = new Chart(pieContext).Pie(pieData, {responsive : true});

        var pieContext2 = document.getElementById("class-subject-report").getContext("2d");
        window.myPie2 = new Chart(pieContext2).Pie(pieData2, {responsive : true});
    };

</script>
@endif

@endsection
