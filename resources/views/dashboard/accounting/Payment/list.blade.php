@extends('layout.dashboard')

@section('title', 'Fee Dashboard-v1')

@section('content')

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2><div class="page-title">Fee Dashboard-v1</h2>

                <div class="row">
                    <div class="col-md-12">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-info text-light">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1">
                                                <i class="fa fa-inr"></i> {{amount($payment->scheduled_amount)}}
                                            </div>
                                            <div class="stat-panel-title text-uppercase">
                                                Schedule fee
                                            </div>
                                        </div>
                                    </div>
                                    <a class="block-anchor panel-footer text-center" href="/cabinet/fee-dashboard-v1/schedule-fee">Full Details &nbsp;<i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-danger text-light">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1">
                                                <i class="fa fa-inr"></i> {{amount($payment->collection_amount)}}
                                            </div>
                                            <div class="stat-panel-title text-uppercase">
                                                Collection
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#" class="block-anchor panel-footer text-center">&nbsp;</a>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-warning text-light">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1">
                                                <i class="fa fa-inr"></i> {{amount($payment->due_amount)}}
                                            </div>
                                            <div class="stat-panel-title text-uppercase">
                                                Due
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#" class="block-anchor panel-footer text-center">&nbsp;</a>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-success text-light">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1">
                                                <i class="fa fa-inr"></i> {{amount($payment->discount_amount)}}
                                            </div>
                                            <div class="stat-panel-title text-uppercase">
                                                Discount
                                            </div>
                                        </div>
                                    </div>
                                    <a class="block-anchor panel-footer text-center" href="/cabinet/fee-dashboard-v1/discount">Full Details &nbsp; <i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <span style="margin-right: 5px;">Collection Report</span>
                                <div class="btn-group">
                                    <a class="btn btn-info {{activeLink(1, 'fi', true)}}" href="/cabinet/fee-dashboard-v1?fi=1">Current Week</a>
                                    <a class="btn btn-info {{activeLink(2, 'fi')}}" href="/cabinet/fee-dashboard-v1?fi=2">Current Month</a>
                                    <a class="btn btn-info {{activeLink(3, 'fi')}}" href="/cabinet/fee-dashboard-v1?fi=3">Current Quater</a>
                                    <a class="btn btn-info {{activeLink(4, 'fi')}}" href="/cabinet/fee-dashboard-v1?fi=4">All</a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <ul class="chart-dot-list">
                                            <?php $i=1; ?>
                                            @foreach($payment->collectionChart as $row)
                                                <li class="a{{$i++}}">{{$row['label']}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="chart chart-doughnut">
                                            <canvas height="900" id="collection-report" width= "1200"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                Collection Details
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="table-collection" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Fee type</th>
                                                <th>Collection amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($payment->collectionGrid as $row)
                                            <tr>
                                                <td>{{$row['receipt_date']}}</td>
                                                <td>{{$row['product_name']}}</td>
                                                <td><i class="fa fa-inr"></i> {{amount($row['collection_amount'])}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                Due Report
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <ul class="chart-dot-list">
                                            <?php $i=1; ?>
                                            @foreach($payment->dueDoughnut as $row)
                                                <li class="a{{$i++}}">{{$row['product_name']}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="chart chart-doughnut">
                                            <canvas height="900" id="due-report" width="1200"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                Due Details
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="table-student" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Student</th>
                                                <th>Class</th>
                                                <th>Due amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($payment->dueDetails as $row)
                                            <tr>
                                                <td>{{$row['account_name']}}</td>
                                                <td>{{$row['class_name']}}</td>
                                                <td><i class="fa fa-inr"></i> {{amount($row['due_amount'])}}</td>
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

    var dueDoughnut = <?php echo json_encode($payment->dueDoughnutChart); ?>;
    dueDoughnut = applyChartColors(dueDoughnut);

    var pieData = <?php echo json_encode($payment->collectionChart); ?>;
    pieData = applyChartColors(pieData);

    $(document).ready(function() {
        $('#table-student').DataTable();
        $('#table-collection').DataTable();
    });

    window.onload = function() {
        // Pie Chart from doughutData
        var pieContext = document.getElementById("collection-report").getContext("2d");
        window.myPie = new Chart(pieContext).Pie(pieData, {responsive : true});

        // Dougnut Chart from dueDoughnut
        var doughnutContext = document.getElementById("due-report").getContext("2d");
        window.myDoughnut = new Chart(doughnutContext).Doughnut(dueDoughnut, {responsive : true});
    };
</script>
@endsection
