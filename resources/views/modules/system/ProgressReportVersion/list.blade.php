@extends('layout.cabinet')

@section('title', 'Progress Report Version')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Progress Report Version</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" action="" method="POST">
                <div class="row">
                    <div class="col-md-5">

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="exam-entity-id-filter">Exam</label>
                            <div class="col-md-8">
                                <select id="exam-entity-id-filter" class="form-control" name="exam-entity-id-filter">
                                    <option value="none">Select an exam ..</option>
                                    @foreach($version->examDropdown() as $option)
                                        <option {{ activeSelect($option['exam_entity_id'], 'eei') }} value="{{ $option['exam_entity_id'] }}">{{ $option['exam'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="student-report-version-id">Student Type</label>
                            <div class="col-md-8">
                                <select id="student-report-version-id" class="form-control" name="student-report-version-id">
                                    <option value="none">Select a report version ..</option>
                                    @foreach($version->reportType() as $option)
                                        <option {{ activeSelect($option['student_report_version'], 'rt') }} value="{{ $option['student_report_version'] }}">{{ $option['student_report_version'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

            <hr/>

           <table class="table table-striped table-bordered table-hover" data-datatable>
            <thead>
                <tr>
                    <th class="text-center"><input type="checkbox" id="toggle-subjects" name="toggle-checkbox" value=""></th>
                    <th>Class Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    <th>Version Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                </tr>
            </thead>
            <tbody>

    @foreach($version->rows() as $row)
    <tr>
        <td class="text-center">
            <input type="checkbox" class="class-entity-id" name="report_checkbox" value="{{$row['class_entity_id']}}">
        </td>
        <td>{{$row['class_name']}}</td>
        <td>{{$row['student_report_version']}}</td>
    </tr>
    @endforeach

                </tbody>
            </table>

            @include('commons.modal')

        </div>
    </div>
</div>



<div class="row">
<div class="col-md-12">

<form class="form-horizontal" id="report-form" action="{{form_action_full()}}" method="POST">
    {{ csrf_field() }}

    <input type="hidden" name="classIDS" id="class_student_ids" value="">

    <div class="form-group">
        <label class="col-md-3 col-md-offset-6 control-label" for="report_version_id">Report Version</label>
        <div class="col-md-3">
            <select id="report_version_id" class="form-control" name="report_version_id">
                <option value="none">Select a report version..</option>
                @foreach($version->reportVersion() as $option)
                    <option value="{{$option['report_version_id']}}">{{$option['student_report_version']}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
       <div class="col-md-3 col-md-offset-9">
            <a href="{{ url("/cabinet/progress-report-version")}}" class="btn btn-default">Cancel</a>
            <button type="submit" id="submit-form-btn" disabled="disabled" class="btn btn-primary">Submit</button>
        </div>
    </div>

</form>
</div>
</div>

@endsection


@section('scripts')
<script type="text/javascript">

    $('#exam-entity-id-filter').change(function() {
        updateQueryString();
    });

    $('#student-report-version-id').change(function() {
        updateQueryString();
    });

    function updateQueryString() {
        window.location.href = window.location.href.split('?')[0] + getQueryString();
    }

    // get the query string
    function getQueryString() {
        var eei = $('#exam-entity-id-filter option:selected').val();
        var rt = $('#student-report-version-id option:selected').val();

        var items = [];
        if (eei != "none") {
            items.push('eei='+eei);
        }
        if (rt != "none") {
            items.push('rt='+rt);
        }

        var queryString = items.join('&');
        if (queryString.length > 1) {
            return '?' + queryString;
        }
        return '';
    }

    // Checkbox table header - for this page, toggle all checkboxes
    $('#toggle-subjects').change(function() {
        if($(this).is(":checked")) {
            $('.class-entity-id').prop('checked', true);
        } else {
            $('.class-entity-id').prop('checked', false);
        }
    });

    // Disable/Enable Button depending if checkboxes are selected
    $('.class-entity-id, #toggle-subjects').change(function() {
        if ($('.class-entity-id:checked').length > 0) {
            $('#submit-form-btn').prop('disabled', false);
        } else {
            $('#submit-form-btn').prop('disabled', true);
        }
    });

    // When submitting the form, prepend all selected checkboxes
    $('#report-form').submit(function() {
        if (! $('#report-form').valid()) {
            return false;
        }

        var studentIds = $('.class-entity-id:checked').map(function() {
            return this.value;
        }).get();

        if (studentIds.length == 0) {
            alert("No rows are selected.");
            return false;
        }

        $('#class_student_ids').val(studentIds.join('|'));

        return true;
    });

    $('#report-form').validate({
        rules: {
            report_version_id: {
                requiredSelect: true
            }
        }
    });

</script>
@endsection
