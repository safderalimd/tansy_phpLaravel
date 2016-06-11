<!DOCTYPE html>
<html lang="en">
<head>
    @include('include.meta-and-title')
    <link type="text/css" href="/dashboard/font-awesome.min.css" rel="stylesheet">
    <link type="text/css" href="/dashboard/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="/dashboard/dataTables.bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="/dashboard/bootstrap-select.css" rel="stylesheet">
    <link type="text/css" href="/dashboard/fileinput.min.css" rel="stylesheet">
    <link type="text/css" href="/dashboard/dashboard.css" rel="stylesheet">
    <link type="text/css" href="/bower_components/bootstrap-checkbox-x/css/checkbox-x.min.css" rel="stylesheet">
    <link href="/css/simple-sidebar.css" rel="stylesheet">
    <link type="text/css" href="/dashboard/custom.css?v=3" rel="stylesheet">
    @yield('styles')
    <style type="text/css">
        .flash-message {
            background-color: #99c93d;
            display: inline-block;
            padding: 12px 30px;
            color: #fff;
            border-radius: 4px;
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 15px;
            line-height: 1.6em;
            font-family: Lato, sans-serif;
            display: none;
        }
        .flash-message .material-icons {
            margin-right: 8px;
            vertical-align: middle;
        }
    </style>
</head>
<body style="padding:0px;">
<div class="loader"></div>
@include('commons.flash')
<div class="container-fluid">

    <header class="row">
        @include('include.navbar')
    </header>


    <div id="wrapper">

        <div id="sidebar-wrapper">
            <div class="sidebar-nav">
                @include('include.sidebar')
            </div>
        </div>

        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @yield('content')
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @include('include.footer')
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
<script type="text/javascript" src="/bower_components/bootstrap-checkbox-x/js/checkbox-x.min.js"></script>
<script src="/dashboard/custom.js"></script>
<script type="text/javascript">

    $("#sidebar-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    // when page reloads show preloader
    window.onunload = function() {
        $('.loader').fadeIn();
    }
    window.onbeforeunload = function() {
        $('.loader').fadeIn();
    }
</script>

@yield('scripts')

</body>
</html>
