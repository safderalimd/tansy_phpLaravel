@extends('layout.cabinet')

@section('title', 'School Classes')

@section('content')

        <div class="panel-group sch_class">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th-list"></i>
                    <h3>Class Subject Mapping</h3>
                </div>
                <div class="panel-body">

                    @include('commons.errors')

                <table class="table table-striped table-bordered table-hover" id="class-subject-map-table">
                    <thead>
                        <tr>
                            <th>Class <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Subject <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Mapped <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
            @foreach($subjects->classSubjectsGrid() as $subject)
            <tr>
                <td>{{$subject['class_name']}}</td>
                <td>{{$subject['subject']}}</td>
                <td>{{$subject['mapped']}}</td>
                <td>
                    @if (strtolower($subject['mapped']) == 'yes')
                        <a class="btn-link-action btn btn-warning" href="{{url("/cabinet/class-subject-map/delete/{$subject['class_entity_id']}/{$subject['subject_entity_id']}")}}"
                           title="Delete"
                           data-title="Delete Subject Map"
                           data-message="Are you sure to delete the selected record?"
                        >
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete
                        </a>
                    @else
                        <a class="btn-link-action btn btn-success" href="{{url("/cabinet/class-subject-map/map/{$subject['class_entity_id']}/{$subject['subject_entity_id']}")}}"
                           title="Map"
                           data-title="Map Subject"
                           data-message="Are you sure to map the selected record?"
                        >
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Map
                        </a>
                    @endif
                </td>
            </tr>
            @endforeach
                        </tbody>
                    </table>

                    @include('commons.modal')

                </div>
            </div>
        </div>

@endsection

@section('scripts')
<script type="text/javascript">

    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    $(document).ready(function() {

        $('#class-subject-map-table').DataTable({
            "aaSorting": [],
            "autoWidth": false
        });

        // set the current page
        var pageNr = getParameterByName('page');
        if (pageNr) {
            pageNr = parseInt(pageNr);
            $('#class-subject-map-table').dataTable().fnPageChange(pageNr);
        }

    });

    // add current page when changing the page
    $('.btn-link-action').on('click', function(e) {
        e.preventDefault();
        var el = $(this);
        var title = el.attr('data-title');
        var msg = el.attr('data-message');
        var dataForm = el.attr('href');
        dataForm += '?page=' + $('#class-subject-map-table').DataTable().page();
        $('#formConfirm')
                .find('#frm_body').html(msg)
                .end().find('#frm_title').html(title)
                .end().modal('show');

        $('#formConfirm').find('#frm_submit').attr('href', dataForm);
    });

</script>
@endsection
