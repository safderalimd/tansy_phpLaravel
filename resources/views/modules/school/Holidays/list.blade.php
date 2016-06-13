@extends('layout.cabinet')

@section('title', 'Attendance')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Attendance</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" action="" method="POST">

                <div class="form-group">
                    <label class="col-sm-3 col-md-2 control-label" for="facility_id">Facility</label>
                    <div class="col-sm-3 col-md-3">
                        <select id="facility_id" class="form-control" name="facility_id">
                            <option value="none">Select a facility..</option>
                            @foreach($holidays->facilities() as $option)
                                <option value="{{ $option['facility_entity_id'] }}">{{ $option['facility_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 col-md-2 control-label" for="month_id">Month</label>
                    <div class="col-sm-3 col-md-3">
                        <select id="month_id" class="form-control" name="month_id">
                            <option value="none">Select a month..</option>
                            @foreach($holidays->months() as $option)
                                <option {{ activeSelect($option['month_id'], 'mi') }} value="{{ $option['month_id'] }}">{{ $option['calendar_month'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>

            <table id="holidays-table" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Date <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Holiday</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($holidays->rows() as $item)
                    <tr>
                        <?php
                            $holiday = holiday($item['holiday']);
                        ?>
                        <td>{{$item['calendar_date_name']}}</td>
                        <td>
                            <input type="checkbox" value="{{$holiday}}" class="holiday_id" name="holiday_id" data-dateId="{{$item['date_id']}}" >
                        </td>
                        <td>
                            <input @if (!$holiday) disabled="disabled" @endif type="text" class="description form-control" name="description" value="{{$item['description']}}" placeholder="">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <nav class="nav-footer navbar navbar-default">
                <div class="container-fluid">
                    <form class="navbar-form navbar-right" id="update-holidays-form" action="{{form_action_full()}}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="facility_entity_id" id="facility_entity_id" value="">
                        <input type="hidden" name="account_ids" id="account_ids" value="">

                        <a class="btn btn-default" href="/cabinet/holidays">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Holidays</button>
                    </form>
                </div>
            </nav>

            @include('commons.modal')

        </div>
    </div>
</div>

@endsection


@section('scripts')
<script type="text/javascript">

    $(".holiday_id").checkboxX({
        iconChecked: "<b>X</b>",
        threeState: false
    });

    $('.holiday_id').change(function() {
        if ($(this).is(':checked')) {
            $($(this).closest('tr')).find('.description').prop('disabled', false);
        } else {
            $($(this).closest('tr')).find('.description').prop('disabled', true);
        }
    });

    // create datatale with checkbox column unsortable
    $('#holidays-table').DataTable( {
       "aoColumnDefs": [
           { 'bSortable': false, 'aTargets': [ 0 ] }
        ],
        "bPaginate": false
    });

    // when the account types dropdown changes redirect
    $('#month_id').change(function() {
        updateQueryString();
    });

    function updateQueryString() {
        window.location.href = window.location.href.split('?')[0] + getQueryString();
    }

    // get the query string
    function getQueryString() {
        var mi = $('#month_id option:selected').val();

        var items = [];
        if (mi != "none") {
            items.push('mi='+mi);
        }

        var queryString = items.join('&');
        if (queryString.length > 1) {
            return '?' + queryString;
        }
        return '';
    }

    $('#update-holidays-form').submit(function() {
        var facility = $('#facility_id option:selected').val();

        if (facility == 'none') {
            alert('Please select a facility!');
            return false;
        }

        $('#facility_entity_id').val(facility);

        var rowIds = [];
        $('.holiday_id').each(function() {
            if ($(this).val() == 1) {
                var dateId = $(this).attr('data-dateId');
                var description = $($(this).closest('tr')).find('.description').val();
                description = description.replace(/[-,]/g, ' ');
                rowIds.push(dateId + '-' + description);
            }
        });

        $('#account_ids').val(rowIds.join(','));

        return true;
    });
</script>
@endsection
