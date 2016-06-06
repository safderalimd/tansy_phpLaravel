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
    <link href="/css/simple-sidebar.css" rel="stylesheet">
    <link type="text/css" href="/dashboard/custom.css?v=3" rel="stylesheet">
    @yield('styles')
</head>
<body style="padding:0px;">
<div class="loader"></div>
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
