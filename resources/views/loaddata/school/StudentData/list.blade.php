@extends('layout.cabinet')

@section('title', 'Student Data Load')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Student Data Load</h3>
        </div>
        <div class="panel-body">
            @include('commons.errors')


            <form class="form-horizontal" action="{{ form_action() }}" method="POST">
                {{ csrf_field() }}

                @include('commons.select', [
                    'label'   => 'Account Type' ,
                    'name'    => 'account_type_id',
                    'options' => $payment->accountType(),
                    'keyId'   => 'entity_type_id',
                    'keyName' => 'entity_type',
                ])

                <div class="row">
                   <div class="col-md-12 text-center">
                        <button class="btn btn-primary" type="submit">Select Facility</button>
                        <a href="{{ url("/cabinet/product")}}" class="btn btn-default cancle_btn">Cancel</a>
                    </div>
                </div>
            </form>

            <span class="btn btn-success fileinput-button">
                <i class="glyphicon glyphicon-plus"></i>
                <span>Select file...</span>
                <input id="fileupload" type="file" name="files">
            </span>

            <br/>
            <br/>

            <div id="progress" class="progress">
                <div class="progress-bar progress-bar-success"></div>
            </div>

            <!-- The container for the uploaded files -->
            <div id="files" class="files"></div>

            @include('commons.modal')
        </div>
    </div>
</div>

@endsection



@section('scripts')

<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="/jquery-file-upload/jquery.ui.widget.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="/jquery-file-upload/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="/jquery-file-upload/js/jquery.fileupload.js"></script>

<script type="text/javascript">
    $(function () {
        'use strict';
        var url = '/server/php/';

        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('<p/>').text(file.name).appendTo('#files');
                });
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css('width', progress + '%');
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');

    });
</script>

@endsection


@section('styles')

<!-- Generic page styles -->
<link rel="stylesheet" href="/jquery-file-upload/css/style.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="/jquery-file-upload/css/jquery.fileupload.css">

@endsection
