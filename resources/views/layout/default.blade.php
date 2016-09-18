<!DOCTYPE html>
<html lang="en">
<head>
    @include('include.head')
    @yield('styles')
</head>
<body class="@yield('screen-name')">
<div class="container-fluid">

    <main class="row">
        <div class="col-sm-12">
            @yield('content')
        </div>

    </main>

    <footer>
        @include('include.footer')
    </footer>

</div>
<script src="/js/app.js"></script>
</body>
</html>
