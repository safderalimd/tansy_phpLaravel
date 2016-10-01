@extends('layout.cabinet')

@section('title', 'Account - Quick Update')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Account - Quick Update</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" action="" method="POST">
                <div class="form-group">
                    <label class="col-sm-3 col-md-2 control-label" for="ui-field">UI Field</label>
                    <div class="col-sm-3 col-md-3">
                        <select id="ui-field" class="form-control" name="ui-field">
                            <option value="none">Select a field..</option>
                            @foreach($update->organizationFields as $option)
                                <option {{activeSelect($option['field_id'], 'fi')}} value="{{ $option['field_id'] }}">{{ $option['field_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @if ($update->fieldType == 'Student')
                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 control-label" for="student-filter">Student</label>
                        <div class="col-sm-3 col-md-3">
                            <select id="student-filter" class="form-control" name="student-filter">
                                <option value="none">Select a student..</option>
                                @foreach($update->studentFilter() as $option)
                                    <option {{activeSelect($option['entity_id'], 'si')}} value="{{ $option['entity_id'] }}">{{ $option['drop_down_list_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif

            </form>

            <form id="table-validation">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center"><input type="checkbox" id="toggle-subjects" name="toggle-checkbox" value=""></th>
                        @foreach ($update->columns() as $column)
                            <th>{{$column}}</th>
                        @endforeach
                        <th>{{$update->uiLabel}}</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; ?>
                    @foreach($update->rows as $row)
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="checkbox-row-id" name="" value="{{$row['account_entity_id']}}">
                        </td>
                        @foreach ($update->columns() as $column)
                            <td>
                                @if (isset($row[$column]))
                                    {{$row[$column]}}
                                @endif
                            </td>
                        @endforeach
                        <td>
                            @if ($update->dataType == 'DROP DOWN')
                                <select disabled="disabled" data-type="dropdown" name="account_row_id{{$i}}" class="form-control account-row-id">
                                    <option value="none">Select..</option>
                                    @foreach ($update->getDropdownOptions() as $option)
                                        <option @if ($option['name'] == $row['Field Value']) selected="selected" @endif value="{{$option['id']}}">{{$option['name']}}</option>
                                    @endforeach
                                </select>

                            @elseif ($update->dataType == 'FLAG')
                                <input  disabled="disabled" data-type="flag" type="checkbox" name="account_row_id{{$i}}" class="form-control account-row-id" value="" @if($row['Field Value'] == 1) checked="checked" @endif>

                            @elseif ($update->dataType == 'NUMBER')
                                <input data-rule-number="true" data-rule-min="0" disabled="disabled" data-type="number" type="text" name="account_row_id{{$i}}" class="form-control account-row-id" value="{{$row['Field Value']}}">

                            @elseif ($update->dataType == 'DATE')
                                <div class="input-group date">
                                    <input disabled="disabled" class="form-control account-row-id" type="text" name="account_row_id{{$i}}" data-type="date" value="{{$row['Field Value']}}">
                                    <span class="input-group-btn">
                                        <button disabled="disabled" class="calendar-button btn btn-default" type="button"><span
                                                    class="glyphicon glyphicon-calendar"></span></button>
                                    </span>
                                </div>

                            @elseif ($update->dataType == 'TEXT')
                                <input disabled="disabled" data-type="text" type="text" name="account_row_id{{$i}}" class="form-control account-row-id" value="{{$row['Field Value']}}">
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </form>

            @include('commons.modal')

            <nav class="nav-footer navbar navbar-default">
                <div class="container-fluid">
                    <form class="navbar-form navbar-right" id="update-form" action="{{form_action_full()}}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="accountEntityID_value" id="collection_ids" value="">
                        <a href="{{ url("/cabinet/account---quick-update")}}" class="btn btn-default cancle_btn">Cancel</a>
                        <button @if (0 == count($update->rows)) disabled="disabled" @endif id="update-button" type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </nav>


        </div>
    </div>
</div>

@endsection


@section('scripts')
<script type="text/javascript">

    // when the account types dropdown changes redirect
    $('#ui-field, #student-filter').change(function() {
        updateQueryString();
    });

    function updateQueryString() {
        window.location.href = window.location.href.split('?')[0] + getQueryString();
    }

    // get the query string
    function getQueryString() {
        var fi = $('#ui-field option:selected').val();
        var si = $('#student-filter option:selected').val();

        var items = [];
        if (fi != "none") {
            items.push('fi='+fi);
        }
        if (si != "none" || si == null) {
            items.push('si='+si);
        }

        var queryString = items.join('&');
        if (queryString.length > 1) {
            return '?' + queryString;
        }
        return '';
    }

    // check/uncheck all checkboxes
    $('#toggle-subjects').change(function() {
        if($(this).is(":checked")) {
            $('.checkbox-row-id').prop('checked', true);
            $('.account-row-id').prop('disabled', false);
            $('.calendar-button').prop('disabled', false);
        } else {
            $('.checkbox-row-id').prop('checked', false);
            $('.account-row-id').prop('disabled', true);
            $('.calendar-button').prop('disabled', true);
        }
    });

    $('.checkbox-row-id').change(function() {
        if($(this).is(":checked")) {
            $(this).closest('tr').find('.account-row-id').prop('disabled', false);
            $(this).closest('tr').find('.calendar-button').prop('disabled', false);
        } else {
            $(this).closest('tr').find('.account-row-id').prop('disabled', true);
            $(this).closest('tr').find('.calendar-button').prop('disabled', true);
        }
    });

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

</script>
@endsection
