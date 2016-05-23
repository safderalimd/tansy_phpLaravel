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
                                                <i class="fa fa-inr"></i> 25,000
                                            </div>
                                            <div class="stat-panel-title text-uppercase">
                                                Schedule fee
                                            </div>
                                        </div>
                                    </div>
                                    <a class="block-anchor panel-footer text-center" href="#">Full Details &nbsp;<i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-danger text-light">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1">
                                                <i class="fa fa-inr"></i> 15,000
                                            </div>
                                            <div class="stat-panel-title text-uppercase">
                                                Collection
                                            </div>
                                        </div>
                                    </div>
                                    <a class="block-anchor panel-footer text-center" href="#">Full Details &nbsp; <i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-warning text-light">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1">
                                                <i class="fa fa-inr"></i> 10,000
                                            </div>
                                            <div class="stat-panel-title text-uppercase">
                                                Due
                                            </div>
                                        </div>
                                    </div>
                                    <a class="block-anchor panel-footer text-center" href="#">Full Details &nbsp; <i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-success text-light">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1">
                                                <i class="fa fa-inr"></i> 12,000
                                            </div>
                                            <div class="stat-panel-title text-uppercase">
                                                Discount
                                            </div>
                                        </div>
                                    </div>
                                    <a class="block-anchor panel-footer text-center" href="#">Full Details &nbsp; <i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                Collection Report
                                <div class="btn-group">
                                    <a class="btn btn-info" href="#">Current Week</a>
                                    <a class="btn btn-info" href="#">Current Month</a>
                                    <a class="btn btn-info" href="#">Current Quater</a>
                                    <a class="btn btn-info" href="#">All</a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <ul class="chart-dot-list">
                                            <li class="a1">Term fee</li>
                                            <li class="a2">Special fee</li>
                                            <li class="a3">Admission fee</li>
                                            <li class="a4">Material fee</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="chart chart-doughnut">
                                            <canvas height="900" id="chart-area3" width=
                                            "1200">
                                            </canvas>
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
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Date</th>
                                                <th>Fee type</th>
                                                <th>Collection amount</th>
                                            </tr>
                                            <tr>
                                                <td>12/9/2016</td>
                                                <td>Term fee</td>
                                                <td><i class="fa fa-inr"></i> 10,000</td>
                                            </tr>
                                            <tr>
                                                <td>10/6/2016</td>
                                                <td>Admission fee</td>
                                                <td><i class="fa fa-inr"></i> 2,000</td>
                                            </tr>
                                            <tr>
                                                <td>22/6/2016</td>
                                                <td>Special fee</td>
                                                <td><i class="fa fa-inr"></i> 1,000</td>
                                            </tr>
                                            <tr>
                                                <td>19/5/2016</td>
                                                <td>material fee</td>
                                                <td><i class="fa fa-inr"></i> 1,000</td>
                                            </tr>
                                            <tr>
                                                <td>17/11/2016</td>
                                                <td>Term fee</td>
                                                <td><i class="fa fa-inr"></i> 1,200</td>
                                            </tr>
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
                                            <li class="a1">Term fee</li>
                                            <li class="a2">Special fee</li>
                                            <li class="a3">Admission fee</li>
                                            <li class="a4">Material fee</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="chart chart-doughnut">
                                            <canvas height="900" id="chart-area4" width=
                                            "1200">
                                            </canvas>
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
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Student</th>
                                                <th>Class</th>
                                                <th>Due amount</th>
                                            </tr>
                                            <tr>
                                                <td>Ramesh</td>
                                                <td>VII</td>
                                                <td><i class="fa fa-inr"></i> 12,000</td>
                                            </tr>
                                            <tr>
                                                <td>rajesh</td>
                                                <td>VI</td>
                                                <td><i class="fa fa-inr"></i> 13,000</td>
                                            </tr>
                                            <tr>
                                                <td>salman</td>
                                                <td>V</td>
                                                <td><i class="fa fa-inr"></i> 12,000</td>
                                            </tr>
                                            <tr>
                                                <td>raju</td>
                                                <td>III</td>
                                                <td><i class="fa fa-inr"></i> 11,200</td>
                                            </tr>
                                            <tr>
                                                <td>raju</td>
                                                <td>IV</td>
                                                <td><i class="fa fa-inr"></i> 10,000</td>
                                            </tr>
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
var doughnutData = [
    {
        value: 10000,
        color:" #FFBB00",
        highlight: " #FFBB11",
        label: "Term fee"
    },
     {
        value: 5000,
        color:"#3cba54",
        highlight: "#008744 ",
        label: "Special fee"
    },
     {
        value: 2000,
        color:"#d62d20",
        highlight: "#db3236",
        label: "Admission fee"
    },
    {
        value: 4000,
        color:"#4885ed",
        highlight: "#0057e7",
        label: "Material fee"
    }
];

var pieData = [
    {
        value: 1120,
        color:"#FFBB00",
        highlight: "#FFBB11",
        label: "Term fee"
    },
    {
        value: 1550,
        color: "#3cba54",
        highlight: "#008744",
        label: "Special fee"
    },
    {
        value: 2010,
        color: "#d62d20",
        highlight: "#db3236",
        label: "Admission fee"
    },
    {
        value: 1100,
        color: "#4885ed",
        highlight: "#0057e7",
        label: "Material fee"
    }
];

$(document).ready(function() {

    $('#zctb').DataTable();

    $("#input-43").fileinput({
        showPreview: false,
        allowedFileExtensions: ["zip", "rar", "gz", "tgz"],
        elErrorContainer: "#errorBlock43"
    });
    // you can configure `msgErrorClass` and `msgInvalidFileExtension` as well

});

window.onload = function() {

    // Pie Chart from doughutData
    var doctx = document.getElementById("chart-area3").getContext("2d");
    window.myDoughnut = new Chart(doctx).Pie(pieData, {responsive : true});

    // Dougnut Chart from doughnutData
    var doctx = document.getElementById("chart-area4").getContext("2d");
    window.myDoughnut = new Chart(doctx).Doughnut(doughnutData, {responsive : true});
};
</script>
@endsection
