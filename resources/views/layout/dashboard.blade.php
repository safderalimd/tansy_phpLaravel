<!DOCTYPE html>
<html lang="en">
<head>
    @include('include.meta-and-title')
    <link type="text/css" href="/dashboard/font-awesome.min.css" rel="stylesheet">
    <link type="text/css" href="/dashboard/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="/dashboard/dataTables.bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="/dashboard/bootstrap-select.css" rel="stylesheet">
    <link type="text/css" href="/dashboard/fileinput.min.css" rel="stylesheet">
    <link type="text/css" href="/dashboard/dashboard.css?v=1" rel="stylesheet">
    <link type="text/css" href="/bower_components/bootstrap-checkbox-x/css/checkbox-x.min.css" rel="stylesheet">
    <link href="/css/simple-sidebar.css" rel="stylesheet">
    <link type="text/css" href="/dashboard/custom.css?v=6" rel="stylesheet">
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
            z-index: 9998;
        }
        .flash-message .material-icons {
            margin-right: 8px;
            vertical-align: middle;
        }

        .chart-dot-circle {
            content: '';
            height: 12px;
            width: 12px;
            margin-right: 6px;
            display: inline-block;
            background: #222;
            border-radius: 50%;
        }

        .img-thumbnail-container {
            display: inline-block;
        }

        .img-thumbnail {
            text-align: center;
            display: block;
            background-color: #29d08a;
/*            width: 340px;
            height: 340px;
*/
            padding: 0px;
            margin-bottom: 20px;
            border: solid 10px #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .helper-img {
            display: inline-block;
            height: 100%;
            vertical-align: middle;
        }

        .img-thumbnail img {
            vertical-align: middle;
        }

        #page-content-wrapper {
            width: 100%!important;
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
<script type="text/javascript" src="/bower_components/list.js/dist/list.min.js"></script>
<script type="text/javascript" src="/bower_components/list.pagination.js/dist/list.pagination.min.js"></script>
<script src="/dashboard/custom.js?v=1"></script>
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

    // for tables
    $( document ).ready(function() {

        // show and remove flash message
        $('.flash-message').fadeIn(300).delay(2800)
            .animate(
                {marginRight: "-100%"},
                300,
                "swing",
                function() {
                    $(this).remove();
                }
            );

    });

</script>

@yield('scripts')

</body>
</html>
