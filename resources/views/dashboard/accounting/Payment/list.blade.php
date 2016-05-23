<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard</title>

<link type="text/css" href="/dashboard/font-awesome.min.css" rel="stylesheet">
<link type="text/css" href="/dashboard/bootstrap.min.css" rel="stylesheet">
<link type="text/css" href="/dashboard/dataTables.bootstrap.min.css" rel="stylesheet">
<link type="text/css" href="/dashboard/bootstrap-select.css" rel="stylesheet">
<link type="text/css" href="/dashboard/fileinput.min.css" rel="stylesheet">
<link type="text/css" href="/dashboard/dashboard.css" rel="stylesheet">

</head>
<body>

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

<script src="/dashboard/jquery.min.js"></script>
<script src="/dashboard/bootstrap-select.min.js"></script>
<script src="/dashboard/bootstrap.min.js"></script>
<script src="/dashboard/jquery.dataTables.min.js"></script>
<script src="/dashboard/dataTables.bootstrap.min.js"></script>
<script src="/dashboard/Chart.min.js"></script>
<script src="/dashboard/fileinput.js"></script>

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

$(document).ready(function () {

    // $(".ts-sidebar-menu li a").each(function () {
    //     if ($(this).next().length > 0) {
    //         $(this).addClass("parent");
    //     };
    // })
    // var menux = $('.ts-sidebar-menu li a.parent');
    // $('<div class="more"><i class="fa fa-angle-down"></i></div>').insertBefore(menux);
    // $('.more').click(function () {
    //     $(this).parent('li').toggleClass('open');
    // });
    // $('.parent').click(function (e) {
    //     e.preventDefault();
    //     $(this).parent('li').toggleClass('open');
    // });
    // $('.menu-btn').click(function () {
    //     $('nav.ts-sidebar').toggleClass('menu-open');
    // });


    $('#zctb').DataTable();


    $("#input-43").fileinput({
        showPreview: false,
        allowedFileExtensions: ["zip", "rar", "gz", "tgz"],
        elErrorContainer: "#errorBlock43"
    });
    // you can configure `msgErrorClass` and `msgInvalidFileExtension` as well

});

window.onload = function(){

    // Pie Chart from doughutData
    var doctx = document.getElementById("chart-area3").getContext("2d");
    window.myDoughnut = new Chart(doctx).Pie(pieData, {responsive : true});

    // Dougnut Chart from doughnutData
    var doctx = document.getElementById("chart-area4").getContext("2d");
    window.myDoughnut = new Chart(doctx).Doughnut(doughnutData, {responsive : true});
};
</script>
<!-- endsection -->
</body>
</html>
