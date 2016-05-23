<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | SamaSchool</title>
    <link type="text/css" href="/dashboard/font-awesome.min.css" rel="stylesheet">
    <link type="text/css" href="/dashboard/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="/dashboard/dataTables.bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="/dashboard/bootstrap-select.css" rel="stylesheet">
    <link type="text/css" href="/dashboard/fileinput.min.css" rel="stylesheet">
    <link type="text/css" href="/dashboard/dashboard.css" rel="stylesheet">
    <link type="text/css" href="/dashboard/custom.css" rel="stylesheet">
</head>
<body style="padding:0px;">
<div class="container-fluid">

    <header class="row">
        @include('include.navbar')
    </header>

    <main class="row">

        <nav class="col-sm-3 col-lg-2">
            @include('include.sidebar')
        </nav>

        <div class="col-sm-9 col-lg-10">
            @yield('content')
        </div>

    </main>

    <footer>
        @include('include.footer')
    </footer>

</div>

<script src="/dashboard/jquery.min.js"></script>
<script src="/dashboard/bootstrap-select.min.js"></script>
<script src="/dashboard/bootstrap.min.js"></script>
<script src="/dashboard/jquery.dataTables.min.js"></script>
<script src="/dashboard/dataTables.bootstrap.min.js"></script>
<script src="/dashboard/Chart.min.js"></script>
<script src="/dashboard/fileinput.js"></script>

@yield('scripts')

</body>
</html>
