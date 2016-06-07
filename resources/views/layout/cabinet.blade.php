<!DOCTYPE html>
<html lang="en">
<head>
    @include('include.head')
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

<script src="/js/app.js"></script>
<script type="text/javascript" src="/bower_components/moment/min/moment.min.js"></script>
<script type="text/javascript" src="/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="/bower_components/bootstrap-combobox/js/bootstrap-combobox-custom.js"></script>
<script type="text/javascript" src="/bower_components/bootstrap-checkbox-x/js/checkbox-x.min.js"></script>

<script>

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
