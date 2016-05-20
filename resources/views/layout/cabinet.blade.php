<!DOCTYPE html>
<html lang="en">
<head>
    @include('include.head')
    @yield('styles')
    <link rel="stylesheet" href="/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
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

<script src="/js/app.js"></script>
<script type="text/javascript" src="/bower_components/moment/min/moment.min.js"></script>
<script type="text/javascript" src="/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

<script>
    // for tables
    $( document ).ready(function() {
        $('.date').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        $('.datetimepicker').datetimepicker({
           format: 'HH:mm:ss'
        });

        $('table[data-datatable]').DataTable({
            "aaSorting": []
        });
    });
</script>

<script type="text/javascript">
    // for bootstrap modal
    $('.formConfirm').on('click', function(e) {
        e.preventDefault();
        var el = $(this);
        var title = el.attr('data-title');
        var msg = el.attr('data-message');
        var dataForm = el.attr('href');

        $('#formConfirm')
                .find('#frm_body').html(msg)
                .end().find('#frm_title').html(title)
                .end().modal('show');

        $('#formConfirm').find('#frm_submit').attr('href', dataForm);
    });
</script>

@yield('scripts')

</body>
</html>
