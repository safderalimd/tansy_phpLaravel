<!DOCTYPE html>
<html lang="en">
<head>
    @include('include.head')
    @yield('styles')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
            z-index: 10000;
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

<script src="/js/app.js"></script>
<script type="text/javascript" src="/bower_components/moment/min/moment.min.js"></script>
<script type="text/javascript" src="/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="/bower_components/bootstrap-combobox/js/bootstrap-combobox-custom.js"></script>
<script type="text/javascript" src="/bower_components/bootstrap-checkbox-x/js/checkbox-x.min.js"></script>
<script type="text/javascript" src="/bower_components/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="/bower_components/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="/js/custom.js"></script>

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

        $('.date').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        $('.datetimepicker').datetimepicker({
           format: 'HH:mm:ss'
        });

        $('table[data-datatable]').DataTable({
            "aaSorting": [],
            "autoWidth": false
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

    // override jquery validate plugin defaults
    $.validator.setDefaults({
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });

    $.validator.addMethod('requiredSelect', function(value, element) {
        return value != 'none';
    }, 'This field is required.');

</script>

@yield('scripts')

</body>
</html>
