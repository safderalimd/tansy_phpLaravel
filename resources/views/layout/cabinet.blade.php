<!DOCTYPE html>
<html lang="en">
<head>
    @include('include.head')
    @yield('styles')
</head>
<body class="@yield('screen-name')">

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

@yield('end-content')

<script src="/js/app.js"></script>
<script type="text/javascript" src="/bower_components/moment/min/moment.min.js"></script>
<script type="text/javascript" src="/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="/bower_components/bootstrap-combobox/js/bootstrap-combobox-custom.js"></script>
<script type="text/javascript" src="/bower_components/bootstrap-checkbox-x/js/checkbox-x.min.js"></script>
<script type="text/javascript" src="/bower_components/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="/bower_components/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="/bower_components/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
<script src="/dashboard/Chart.min.js"></script>
<script type="text/javascript" src="/bower_components/list.js/dist/list.min.js"></script>
<script type="text/javascript" src="/bower_components/list.pagination.js/dist/list.pagination.min.js"></script>
<script type="text/javascript" src="/js/jquery.jscroll.min.js"></script>
<script src="/dashboard/charts.js"></script>

<script type="text/javascript" src="/js/custom.js?v=12"></script>

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
            autoclose: true,
            onSelect: function(dateText) {
                $(this).change();
            }
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
            if(element.parent('.radio-inline').length) {
                error.insertAfter(element.closest('.form-group').find('.radio-inline').last());
            } else if($(element).attr('type') == 'checkbox') {
                error.insertAfter(element.parent());
            } else if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else if(element.parent('.btn-file').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });

    $.validator.addMethod('requiredSelect', function(value, element) {
        if (value == null) {
            return false;
        }
        return value != 'none';
    }, 'This field is required.');

    $.validator.addMethod('requiredMultiSelect', function(value, element) {
        return value != null;
    }, 'This field is required.');

    $.validator.addMethod('greaterThan', function(value, element, params) {
        if (!/Invalid|NaN/.test(new Date(value))) {
            return new Date(value) > new Date($(params).val());
        }
        return isNaN(value) && isNaN($(params).val()) || (Number(value) > Number($(params).val()));
    },'Must be greater than {0}.');

    $.validator.addMethod('phoneNumber', function(phone_number, element) {
        return this.optional(element) || phone_number.match(/^\d{5,12}$/);
    }, "Please specify a valid phone number" );

    $.validator.addMethod('notAtSymbol', function(value, element) {
        return this.optional(element) || !(value.indexOf('@') > -1);
    }, "The @ symbol is not allowed." );

</script>

@yield('scripts')

</body>
</html>
