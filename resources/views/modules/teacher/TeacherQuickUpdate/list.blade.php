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
{{--
            Employee Name" => "CHOTU HAMEED"
            "Short Name" => "Chotu"
            "Department Name" => "HR"
            "Class Teacher" => "X-A"
            "Clasess Per Day" => 6
            "department_id" => 1
            "class_teacher_class_entity_id" => 30
            "account_entity_id" => 176
 --}}
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
                        <td>{{$row['Employee Name']}}</td>
                        <td>{{$row['Short Name']}}</td>
                        <td>{{$row['Department Name']}}</td>
                        <td>{{$row['Class Teacher']}}</td>
                        <td>{{$row['Clasess Per Day']}}</td>
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


{{--             public function getDepartments()
            {
                // department_name, department_id, active
 --}}


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

    $('#table-validation').validate();

    $('#update-form').submit(function() {
        if (! $('#table-validation').valid()) {
            return false;
        }

        var rowIds = $('.checkbox-row-id:checked').map(function() {
            var id = this.value;
            var input = $(this).closest('tr').find('.account-row-id');
            var type = $(input).attr('data-type');
            var v;

            if (type == 'dropdown') {
                v = $('option:selected', input).val();
                if (v == 'none') {
                    v = 'null';
                }
            } else if (type == 'number') {
                v = $(input).val();
            } else if (type == 'date') {
                v = $(input).val();
            } else if (type == 'text') {
                v = $(input).val();
            } else if ($type == 'flag') {
                v = $(input).is(':checked') ? 1 : 0;
            }

            // remove pipe
            if (typeof v == 'string') {
                v = v.replace('|','');
            }

            return id + '<$$>' + v;
        }).get();

        $('#collection_ids').val(rowIds.join('|'));

        return true;
    });












    $('.lookup-table').on('click', '.edit-button', function() {
        var row = $(this).closest('.quick-update-row');
        $('.save-button', row).show();
        $('.cancel-button', row).show();
        $(this).hide();

        var description = $('.td-description', row).text();
        var active = $('.td-active', row).text();
        var reporting_order = $('.td-reporting_order', row).text();

        $('.td-description', row).html($('<input class="form-control" type="text" value="">').val(description));

        if (active == 'Yes') {
            $('.td-active', row).html($('<input class="checkbox" checked="checked" type="checkbox">'));
        } else {
            $('.td-active', row).html($('<input class="checkbox" type="checkbox">'));
        }

        $('.td-reporting_order', row).html($('<input class="form-control" type="text" value="">').val(reporting_order));

        // store original values
        $('.td-description', row).attr('data-original', description);
        $('.td-active', row).attr('data-original', active);
        $('.td-reporting_order', row).attr('data-original',reporting_order);
    });

    $('.lookup-table').on('click', '.cancel-button', function() {
        var row = $(this).closest('.quick-update-row');
        originalRowUneditable(row);
    });

    function originalRowUneditable(row) {
        $('.save-button', row).hide();
        $('.edit-button', row).show();
        $('.cancel-button', row).hide();
        $('.td-description', row).html($('.td-description', row).attr('data-original'));
        $('.td-active', row).html($('.td-active', row).attr('data-original'));
        $('.td-reporting_order', row).html($('.td-reporting_order', row).attr('data-original'));
    }

    function makeRowUneditable(row) {
        $('.save-button', row).hide();
        $('.edit-button', row).show();
        $('.cancel-button', row).hide();

        var description = $('.td-description input', row).val();
        var active = $('.td-active input', row).is(':checked');
        var reporting_order = $('.td-reporting_order input', row).val();

        $('.td-description', row).html(description);
        if (active == true) {
            active = 'Yes';
        } else {
            active = 'No';
        }
        $('.td-active', row).html(active);
        $('.td-reporting_order', row).html(reporting_order);
    }

    $('.lookup-table').on('click', '.save-button', function() {
        var row = $(this).closest('.quick-update-row');
        var primaryKeyId = $(this).attr('data-keyid');
        var isNewRecord = $(this).attr('data-newrecord');
        var saveButton = this;

        var postUrl = '/cabinet/manage-lookups/update';
        if (isNewRecord) {
            postUrl = '/cabinet/manage-lookups/store';
        }
        postUrl = postUrl + '?' + window.location.href.split('?')[1];

        var description = $('.td-description input', row).val();
        var active = $('.td-active input', row).is(':checked');
        var reportingOrder = $('.td-reporting_order input', row).val();

        $(saveButton).button('loading');

        $.ajax({
            type: "POST",
            url: postUrl,
            data: {
                primary_key_id: primaryKeyId,
                description : description,
                active : active,
                reporting_order : reportingOrder
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
