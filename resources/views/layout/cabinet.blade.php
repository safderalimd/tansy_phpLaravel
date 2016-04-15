<!DOCTYPE html>
<html lang="en">
<head>
    @include('include.head')
</head>
<body>
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
<script>
    $( document ).ready(function() {
        $('.date').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        $('table[data-datatable]').DataTable();
    });
</script>

<script type="text/javascript">
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
//
//    $('#formConfirm').on('click', '#frm_submit', function(e) {
//        var id = $(this).attr('data-form');
//        $(id).submit();
//    });
</script>

</body>
</html>