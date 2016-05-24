@extends('layout.dashboard')

@section('title', 'SMS Dashboard')

@section('content')

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2><div class="page-title">SMS Dashboard</h2>

                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-info text-light">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1">
                                                <i class="fa fa-inr"></i> {{sms($sms->total_sms_purchase_count)}}
                                            </div>
                                            <div class="stat-panel-title text-uppercase">
                                                Total Purchased
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-danger text-light">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1">
                                                <i class="fa fa-inr"></i> {{sms($sms->total_sms_send_count)}}
                                            </div>
                                            <div class="stat-panel-title text-uppercase">
                                                Total Send
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-warning text-light">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1">
                                                <i class="fa fa-inr"></i> {{sms($sms->total_sms_balance_count)}}
                                            </div>
                                            <div class="stat-panel-title text-uppercase">
                                                Balance
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-success text-light">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1">
                                                <i class="fa fa-inr"></i> {{$sms->sms_success_rate}}%
                                            </div>
                                            <div class="stat-panel-title text-uppercase">
                                                Success Rate
                                            </div>
                                        </div>
                                    </div>
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
                                    <div class="col-xs-6 col-sm-4">
                                        <h4>
                                        Total Acounts: {{sms($sms->accounts_with_valid_sms_count + $sms->accounts_with_invalid_sms_count + $sms->accounts_with_no_sms_count)}}
                                        <br/>
                                        <br/>
                                        Acounts with valid sms: {{sms($sms->accounts_with_valid_sms_count)}}
                                        <br/>
                                        <br/>
                                        Acounts with invalid sms: {{sms($sms->accounts_with_invalid_sms_count)}}
                                        <br/>
                                        <br/>
                                        Acounts with no sms: {{sms($sms->accounts_with_no_sms_count)}}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading"><span>SMS Count</span></div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <ul class="chart-dot-list">
                                            <ul class="chart-dot-list">
                                                <?php $i=1; ?>
                                                @foreach($sms->smsPieChart as $row)
                                                    <li class="a{{$i++}}">{{$row['label']}}</li>
                                                @endforeach
                                            </ul>
                                        </ul>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="chart chart-doughnut">
                                            <canvas height="900" id="sms-report" width= "1200"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                SMS Batch
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="table-sms-grid" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Batch#</th>
                                                <th>Date</th>
                                                <th>Type</th>
                                                <th>Cost</th>
                                                <th>Success Count</th>
                                                <th>Fail Count</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($sms->gridDetails as $row)
                                            <tr>
                                                <td>{{$row['batch_number']}}</td>
                                                <td>{{$row['batch_date']}}</td>
                                                <td>{{$row['sms_type']}}</td>
                                                <td><i class="fa fa-inr"></i> {{amount($row['sms_cost'])}}</td>
                                                <td>{{$row['sms_success_count']}}</td>
                                                <td>{{$row['sms_fail_count']}}</td>
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

    var smsData = <?php echo json_encode($sms->smsPieChart); ?>;
    smsData = applyChartColors(smsData);

    $(document).ready(function() {
        $('#table-sms-grid').DataTable();
    });

    window.onload = function() {
        var pieContext = document.getElementById("sms-report").getContext("2d");
        window.myPie = new Chart(pieContext).Pie(smsData, {responsive : true});
    };
</script>
@endsection
