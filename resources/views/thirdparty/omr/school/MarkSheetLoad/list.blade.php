@extends('layout.cabinet')

@section('title', 'Mark Sheet Load')

@section('content')

        <div class="panel-group sch_class">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th-list"></i>
                    <h3>Mark Sheet Load</h3>
                </div>
                <div class="panel-body">
                    @include('commons.errors')

                    <!--
                        Process:
                            select multiple files; display them in a grid
                            click 'import' button
                            upload files with ajax
                            process the files one by one (show status next to each file)
                            delete the files after you process them
                     -->

                     <form id="fileupload" action="{{form_action()}}" method="POST" enctype="multipart/form-data">
                         <div class="row fileupload-buttonbar">
                             <div class="col-lg-7">
                                 <span class="btn btn-success fileinput-button">
                                     <i class="glyphicon glyphicon-plus"></i>
                                     <span>Add files...</span>
                                     <input type="file" name="files[]" multiple>
                                 </span>

                             <!-- The global file processing state -->
                             <!-- <span class="fileupload-process"></span></div> -->

                             <!-- The global progress state -->
                             <!-- <div class="col-lg-5 fileupload-progress fade"> -->
                                 <!-- The global progress bar -->
                                 <!-- <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                     <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                 </div> -->                                 <!--
                                  The extended global progress state -->
                                 <!-- <div class="progress-extended">&nbsp;</div> -->
                             </div>
                         </div>

                         <!-- The table listing the files available for upload/download -->
                         <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>

                         <hr/>
                        <div class="row fileupload-buttonbar">
                          <div class="col-lg-12">
                              <button type="submit" class="btn btn-primary start">
                                  <i class="glyphicon glyphicon-upload"></i>
                                  <span>Import</span>
                              </button>
                              <button type="reset" class="btn btn-warning cancel">
                                  <i class="glyphicon glyphicon-ban-circle"></i>
                                  <span>Cancel</span>
                              </button>

                             <!--
                              <button type="button" class="btn btn-danger delete">
                                  <i class="glyphicon glyphicon-trash"></i>
                                  <span>Delete</span>
                              </button>
                              <input type="checkbox" class="toggle">
                              -->
                          </div>
                        </div>

                     </form>


                    @include('commons.modal')
                </div>
            </div>
        </div>

@endsection






@section('scripts')

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <!-- <td><span class="preview"></span></td> -->
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td style="display:none!important">
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>

 </tr>
{% } %}
</script>

<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
<!--         <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td> -->
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td style="display:none!important">
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>

<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="/jquery-file-upload/jquery.ui.widget.js"></script>

<!-- The Templates plugin is included to render the upload/download listings -->
<script src="/jquery-file-upload/tmpl.min.js"></script>

<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="/jquery-file-upload/load-image.all.min.js"></script>

<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="/jquery-file-upload/canvas-to-blob.min.js"></script>

<!-- blueimp Gallery script -->
<script src="/jquery-file-upload/jquery.blueimp-gallery.min.js"></script>

<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="/jquery-file-upload/js/jquery.iframe-transport.js"></script>

<!-- The basic File Upload plugin -->
<script src="/jquery-file-upload/js/jquery.fileupload.js"></script>

<!-- The File Upload processing plugin -->
<script src="/jquery-file-upload/js/jquery.fileupload-process.js"></script>

<!-- The File Upload image preview & resize plugin -->
<script src="/jquery-file-upload/js/jquery.fileupload-image.js"></script>

<!-- The File Upload audio preview plugin -->
<script src="/jquery-file-upload/js/jquery.fileupload-audio.js"></script>

<!-- The File Upload video preview plugin -->
<script src="/jquery-file-upload/js/jquery.fileupload-video.js"></script>

<!-- The File Upload validation plugin -->
<script src="/jquery-file-upload/js/jquery.fileupload-validate.js"></script>

<!-- The File Upload user interface plugin -->
<script src="/jquery-file-upload/js/jquery.fileupload-ui.js"></script>

<!-- The main application script -->
<script src="/jquery-file-upload/js/main.js"></script>

<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="/jquery-file-upload/js/cors/jquery.xdr-transport.js"></script>
<![endif]-->

@endsection





@section('styles')

<!-- Generic page styles -->
<link rel="stylesheet" href="/jquery-file-upload/css/style.css">
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="/jquery-file-upload/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="/jquery-file-upload/css/jquery.fileupload.css">
<link rel="stylesheet" href="/jquery-file-upload/css/jquery.fileupload-ui.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="/jquery-file-upload/css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="/jquery-file-upload/css/jquery.fileupload-ui-noscript.css"></noscript>

@endsection
