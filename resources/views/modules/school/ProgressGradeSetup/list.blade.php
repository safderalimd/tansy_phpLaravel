@extends('layout.cabinet')

@section('title', 'Progress Grade Setup')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Progress Grade Setup</h3>
        </div>
        <div class="panel-body">

            <div class="progress-grade-setup-message alert alert-danger" style="display:none;">
                <ul>
                    <li></li>
                </ul>
            </div>

            <form class="form-horizontal" id="grade-progress-setup-form" action="/cabinet/progress-grade-setup" method="POST">

                <div class="row">
                    <div class="col-md-12">

                        <div class="form-group">
                            <label class="col-md-2 control-label" for="grate-select">Grade System</label>
                            <div class="col-md-3">
                                <select id="grate-select" class="form-control" name="filter_screen_id">
                                    <option value="none">Select a grade system..</option>
                                    @foreach($progress->gradingSystem() as $option)
                                        <option {{ activeSelect($option['grade_system_id'], 'gsi') }} value="{{ $option['grade_system_id'] }}">{{ $option['grade_type'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="grate-pass-fail-select" style="display:none;">
                            <select class="form-control">
                                @foreach($progress->gradePassFail() as $option)
                                    <option value="{{ $option['pass_fail_flag'] }}">{{ $option['pass_fail_flag'] }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <table class="grade-setup-table table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Start Percent</th>
                                    <th>End Percent</th>
                                    <th>Grade</th>
                                    <th>GPA</th>
                                    <th>Pass/Fail</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($progress->rows() as $row)
                                <tr class="progress-grade-setup-row">
                                    <td class="td-start-percent">{{$row['start_percent']}}</td>
                                    <td class="td-end-percent">{{$row['end_percent']}}</td>
                                    <td class="td-grade">{{$row['grade']}}</td>
                                    <td class="td-gpa">{{$row['gpa']}}</td>
                                    <td class="td-pass-fail">{{$row['pass_fail']}}</td>
                                    <td>
                                        <button type="button" class="edit-button btn btn-default">Edit</button>
                                        @if (isset($row['grade_entity_id']))
                                            <button data-loading-text="Saving..." data-keyid="{{$row['grade_entity_id']}}" type="button" style="display:none;" class="save-button btn btn-default">Save</button>
                                            <button title="Delete" data-title="Delete Progress Grade Setup" data-message="Are you sure to delete the selected record?" data-loading-text="Deleting..."  type="button" data-keyid="{{$row['grade_entity_id']}}" class="deleteConfirm delete-button btn btn-default"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($progress->showAddButton())
                    <div class="row">
                       <div class="col-md-12 text-left">
                            <button type="button" id="add-new-row" class="btn btn-primary">Add New Row</button>
                        </div>
                    </div>
                @endif

            </form>

            @include('commons.modal')

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">

    $('#grate-select').change(function() {
        updateQueryString();
    });

    function updateQueryString() {
        window.location.href = window.location.href.split('?')[0] + getQueryString();
    }

    // get the query string
    function getQueryString() {
        var gsi = $('#grate-select option:selected').val();

        var items = [];
        if (gsi != "none") {
            items.push('gsi='+gsi);
        }

        var queryString = items.join('&');
        if (queryString.length > 1) {
            return '?' + queryString;
        }
        return '';
    }

    $('.grade-setup-table').on('click', '.edit-button', function() {
        var row = $(this).closest('.progress-grade-setup-row');
        $('.save-button', row).show();
        $(this).hide();

        var td_start_percent = $('.td-start-percent', row).text();
        var td_end_percent = $('.td-end-percent', row).text();
        var td_grade = $('.td-grade', row).text();
        var td_gpa = $('.td-gpa', row).text();
        var td_pass_fail = $('.td-pass-fail', row).text();

        $('.td-start-percent', row).html($('<input class="form-control" type="text" value="">').val(td_start_percent));
        $('.td-end-percent', row).html($('<input class="form-control" type="text" value="">').val(td_end_percent));
        $('.td-grade', row).html($('<input class="form-control" type="text" value="">').val(td_grade));
        $('.td-gpa', row).html($('<input class="form-control" type="text" value="">').val(td_gpa));

        var selectHtml = $('#grate-pass-fail-select').html();
        if (typeof td_pass_fail == 'string') {
            td_pass_fail = td_pass_fail.trim();
        }
        $('.td-pass-fail', row).html($(selectHtml).val(td_pass_fail));
    });

    function makeRowUneditable(row) {
        $('.save-button', row).hide();
        $('.edit-button', row).show();

        var td_start_percent = $('.td-start-percent input', row).val();
        var td_end_percent = $('.td-end-percent input', row).val();
        var td_grade = $('.td-grade input', row).val();
        var td_gpa = $('.td-gpa input', row).val();
        var td_pass_fail = $('.td-pass-fail option:selected', row).val();

        $('.td-start-percent', row).html(td_start_percent);
        $('.td-end-percent', row).html(td_end_percent);
        $('.td-grade', row).html(td_grade);
        $('.td-gpa', row).html(td_gpa);
        $('.td-pass-fail', row).html(td_pass_fail);
    }

    $('.grade-setup-table').on('click', '.save-button', function() {
        var row = $(this).closest('.progress-grade-setup-row');
        var gradeEntityId = $(this).attr('data-keyid');
        var isNewRecord = $(this).attr('data-newrecord');
        var saveButton = this;

        var postUrl = '/cabinet/progress-grade-setup/update';
        if (isNewRecord) {
            postUrl = '/cabinet/progress-grade-setup/store';
        }
        postUrl = postUrl + '?' + window.location.href.split('?')[1];

        var start_percent = $('.td-start-percent input', row).val();
        var end_percent = $('.td-end-percent input', row).val();
        var grade = $('.td-grade input', row).val();
        var gpa = $('.td-gpa input', row).val();
        var pass_fail = $('.td-pass-fail select option:selected', row).val();

        $(saveButton).button('loading');

        $.ajax({
            type: "POST",
            url: postUrl,
            data: {
                grade_entity_id: gradeEntityId,
                start_percent: start_percent,
                end_percent: end_percent,
                grade: grade,
                gpa: gpa,
                pass_fail: pass_fail
            },
            dataType: "json",
            success: function(data) {
                $(saveButton).button('reset');
                if (data.error) {
                    $('.progress-grade-setup-message').show();
                    $('.progress-grade-setup-message li').text(data.error);
                } else if (data.success) {
                    makeRowUneditable(row);
                    $('.progress-grade-setup-message').hide();
                }
            },
            error: function(errMsg) {
                $(saveButton).button('reset');
                $('.progress-grade-setup-message').show();
                $('.progress-grade-setup-message li').text("An unexpected error occured.");
            }
        });

    });

    $('#add-new-row').on('click', function() {
        var start_percent = '<td class="td-start-percent"><input class="form-control" type="text" value=""></td>';
        var end_percent = '<td class="td-end-percent"><input class="form-control" type="text" value=""></td>';
        var grade = '<td class="td-grade"><input class="form-control" type="text" value=""></td>';
        var gpa = '<td class="td-gpa"><input class="form-control" type="text" value=""></td>';
        var selectHtml = $('#grate-pass-fail-select').html();
        var pass_fail = '<td class="td-pass-fail">'+selectHtml+'</td>';

        var saveButton = '<td><button type="button" data-newrecord="true" data-loading-text="Saving..." class="save-button btn btn-default">Save</button><button type="button" style="display:none;" class="edit-button btn btn-default">Edit</button></td>';

        var html = start_percent + end_percent + grade + gpa + pass_fail + saveButton;
        $('.grade-setup-table tbody').append('<tr class="progress-grade-setup-row">'+html+'</tr>');
    });

    $('body').on('click', '#frm_submit', function() {
        var deleteButton = currentDeleteButton;
        var gradeEntityId = $(deleteButton).attr('data-keyid');
        $('#formConfirm').modal('hide');

        var postUrl = '/cabinet/progress-grade-setup/delete/' + gradeEntityId;
        postUrl = postUrl + '?' + window.location.href.split('?')[1];

        $(deleteButton).button('loading');

        $.ajax({
            type: "POST",
            url: postUrl,
            data: {
                grade_entity_id: gradeEntityId,
            },
            dataType: "json",
            success: function(data) {
                $(deleteButton).button('reset');
                if (data.error) {
                    $('.progress-grade-setup-message').show();
                    $('.progress-grade-setup-message li').text(data.error);
                } else if (data.success) {
                    $(deleteButton).closest('.progress-grade-setup-row').remove();
                    $('.progress-grade-setup-message').hide();
                }
            },
            error: function(errMsg) {
                $(deleteButton).button('reset');
                $('.progress-grade-setup-message').show();
                $('.progress-grade-setup-message li').text("An unexpected error occured.");
            }
        });
    });

    var currentDeleteButton = null;
    $('.deleteConfirm').on('click', function(e) {
        currentDeleteButton = $(this);
        $('#frm_title').html($(this).attr('data-title'));
        $('#frm_body').html($(this).attr('data-message'));
        $('#formConfirm').modal('show');
    });

</script>
@endsection
