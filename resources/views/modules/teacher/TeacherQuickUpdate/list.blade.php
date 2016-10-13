@extends('layout.cabinet')

@section('title', 'Teacher - Quick Update')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Teacher - Quick Update</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" action="" method="POST">
                <div class="form-group">
                    <label class="col-sm-3 col-md-2 control-label" for="department">Department</label>
                    <div class="col-sm-3 col-md-3">
                        <select id="department" class="form-control" name="department">
                            <option value="none">Select a deparment..</option>
                            @foreach($update->department2() as $option)
                                <option {{activeSelect($option['department_id'], 'di')}} value="{{ $option['department_id'] }}">{{ $option['department_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>

            <div class="lookup-error-message alert alert-danger" style="display:none;">
                <ul>
                    <li></li>
                </ul>
            </div>

            <div id="departments-dropdown" style="display:none;">
                <select class="form-control">
                    <option value="none">Select a department..</option>
                    @foreach($update->departments() as $option)
                        <option value="{{ $option['department_id'] }}">{{ $option['department_name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div id="teachers-dropdown" style="display:none;">
                <select class="form-control">
                    <option value="none">Select a class..</option>
                    @foreach($update->class2() as $option)
                        <option value="{{ $option['class_entity_id'] }}">{{ $option['class_name'] }}</option>
                    @endforeach
                </select>
            </div>

            <form id="table-validation">
            <table class="quick-update-table table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Short Name</th>
                        <th>Department Name</th>
                        <th>Class Teacher</th>
                        <th>Clasess Per Day</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; ?>
                    @foreach($update->rows() as $row)
                    <tr class="quick-update-row">
                        <td class="td-employee_name">{{$row['Employee Name']}}</td>
                        <td class="td-short_name">{{$row['Short Name']}}</td>
                        <td data-departmentid="{{$row['department_id']}}" class="td-department_name">{{$row['Department Name']}}</td>
                        <td data-classid="{{$row['class_teacher_class_entity_id']}}" class="td-class_teacher">{{$row['Class Teacher']}}</td>
                        <td class="td-clasess_per_day">{{$row['Clasess Per Day']}}</td>
                        <td>
                            <button type="button" class="edit-button btn btn-default">Edit</button>
                            <button type="button" style="display:none;" class="cancel-button btn btn-default">Cancel</button>
                            <button data-loading-text="Saving..." data-keyid="{{$row['account_entity_id']}}" type="button" style="display:none;" class="save-button btn btn-default">Save</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </form>

            @include('commons.modal')


        </div>
    </div>
</div>

@endsection


@section('scripts')
<script type="text/javascript">

    // when the account types dropdown changes redirect
    $('#department').change(function() {
        updateQueryString();
    });

    function updateQueryString() {
        window.location.href = window.location.href.split('?')[0] + getQueryString();
    }

    // get the query string
    function getQueryString() {
        var di = $('#department option:selected').val();

        var items = [];
        if (di != "none") {
            items.push('di='+di);
        }

        var queryString = items.join('&');
        if (queryString.length > 1) {
            return '?' + queryString;
        }
        return '';
    }

    var nameIndex = 0;
    $('.quick-update-table').on('click', '.edit-button', function() {
        var row = $(this).closest('.quick-update-row');
        $('.save-button', row).show();
        $('.cancel-button', row).show();
        $(this).hide();

        var short_name = $('.td-short_name', row).text();
        var clasess_per_day = $('.td-clasess_per_day', row).text();
        var department_name_id = $('.td-department_name', row).attr('data-departmentid');
        var class_teacher_id = $('.td-class_teacher', row).attr('data-classid');

        if (department_name_id == '') department_name_id = 'none';
        if (class_teacher_id == '') class_teacher_id = 'none';

        $('.td-short_name', row).html($('<input class="form-control" type="text" value="">').val(short_name));
        $('.td-clasess_per_day', row).html($('<input class="form-control" name="class_per_day_'+nameIndex+'" type="text" value="">').val(clasess_per_day));
        nameIndex++;
        $('.td-clasess_per_day input', row).rules('add', {
            required: true,
            number: true,
            min:0
        });

        $('.td-department_name', row).html($($('#departments-dropdown').html()).val(department_name_id));
        $('.td-class_teacher', row).html(
            $($('#teachers-dropdown').html()).val(class_teacher_id));

        $('.td-short_name', row).attr('data-original', short_name);
        $('.td-clasess_per_day', row).attr('data-original', clasess_per_day);
        $('.td-department_name', row).attr('data-original', department_name_id);
        $('.td-class_teacher', row).attr('data-original', class_teacher_id);
    });

    $('.quick-update-table').on('click', '.cancel-button', function() {
        var row = $(this).closest('.quick-update-row');
        originalMakeRowUneditable(row);
    });

    function originalMakeRowUneditable(row) {
        $('.save-button', row).hide();
        $('.edit-button', row).show();
        $('.cancel-button', row).hide();

        $('.td-short_name', row).html($('.td-short_name', row).attr('data-original'));
        $('.td-clasess_per_day', row).html($('.td-clasess_per_day', row).attr('data-original'));

        var departmentId = $('.td-department_name', row).attr('data-original');
        $('.td-department_name', row).html($('.td-department_name select option[value="'+departmentId+'"]').text());

        var classId = $('.td-class_teacher', row).attr('data-original');
        $('.td-class_teacher', row).html($('.td-class_teacher select option[value="'+classId+'"]').text());
    }

    function makeRowUneditable(row) {
        $('.save-button', row).hide();
        $('.edit-button', row).show();
        $('.cancel-button', row).hide();

        var shortName = $('.td-short_name input', row).val();
        var department = $('.td-department_name select option:selected', row).text();
        var classTeacherClassEntity = $('.td-class_teacher select option:selected', row).text();
        var teacherPeriodsQuotaPerDay = $('.td-clasess_per_day input', row).val();

        $('.td-short_name', row).html(shortName);
        $('.td-department_name', row).html(department);
        $('.td-class_teacher', row).html(classTeacherClassEntity);
        $('.td-clasess_per_day', row).html(teacherPeriodsQuotaPerDay);
    }

    $('#table-validation').validate();

    $('.quick-update-table').on('click', '.save-button', function() {
        var row = $(this).closest('.quick-update-row');

        if (! $('.td-clasess_per_day input', row).valid()) {
            return false;
        }

        var accountEntityId = $(this).attr('data-keyid');
        var saveButton = this;

        var postUrl = '/cabinet/teacher---quick-update';
        postUrl = postUrl + '?' + window.location.href.split('?')[1];

        var shortName = $('.td-short_name input', row).val();
        var departmentId = $('.td-department_name select option:selected', row).val();
        var classTeacherClassEntityId = $('.td-class_teacher select option:selected', row).val();
        var teacherPeriodsQuotaPerDay = $('.td-clasess_per_day input', row).val();

        $('.td-department_name', row).attr('data-departmentid', departmentId);
        $('.td-class_teacher', row).attr('data-classid', classTeacherClassEntityId);

        $(saveButton).button('loading');

        $.ajax({
            type: "POST",
            url: postUrl,
            data: {
                account_entity_id: accountEntityId,
                short_name: shortName,
                row_department_id: departmentId,
                class_teacher_class_entity_id: classTeacherClassEntityId,
                teacher_periods_quota_per_day: teacherPeriodsQuotaPerDay
            },
            dataType: "json",
            success: function(data) {
                $(saveButton).button('reset');
                if (data.error) {
                    $('.lookup-error-message').show();
                    $('.lookup-error-message li').text(data.error);
                } else if (data.success) {
                    makeRowUneditable(row);
                    $('.lookup-error-message').hide();
                }
            },
            error: function(errMsg) {
                $(saveButton).button('reset');
                $('.lookup-error-message').show();
                $('.lookup-error-message li').text("An unexpected error occured.");
            }
        });

    });

</script>
@endsection
