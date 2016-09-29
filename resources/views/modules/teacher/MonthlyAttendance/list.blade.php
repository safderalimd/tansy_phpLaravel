@extends('layout.cabinet')

@section('title', 'Monthly Attendance')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Monthly Attendance</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" action="" method="POST">
                <div class="form-group">
                    <label class="col-sm-3 col-md-2 control-label" for="month_id">Month</label>
                    <div class="col-sm-3 col-md-3">
                        <select id="month_id" class="form-control" name="mi">
                            <option value="none">Select a month..</option>
                            @foreach($attendance->months() as $option)
                                <option {{activeSelect($option['month_id'], 'mi')}} value="{{ $option['month_id'] }}">{{ $option['calendar_month'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 col-md-2 control-label" for="account_type_entity_id">Account Type</label>
                    <div class="col-sm-3 col-md-3">
                        <select id="account_type_entity_id" class="form-control" name="aei">
                            <option value="none">Select an account..</option>
                            @foreach($attendance->accountTypeFilter3() as $option)
                                <option {{activeSelect($option['entity_id'], 'aei')}} value="{{ $option['entity_id'] }}">{{ $option['drop_down_list_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>

            <table id="attendance-table" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Student Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Section <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Absent</th>
                    </tr>
                </thead>
                <tbody>
                    {{dd($attendance->rows())}}
                    @foreach([] as $item)
                    <tr>
                        <td>{{$item['account_name']}}</td>
                        <td>{{$item['section']}}</td>
                        <td>
                            <input type="checkbox" value="{{absent($item['absent'])}}" class="account_entity_id" name="account_entity_id" data-accountId="{{$item['account_entity_id']}}" >
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <nav class="nav-footer navbar navbar-default">
                <div class="container-fluid">
                    <form class="navbar-form navbar-right" id="update-attendance-form" action="{{form_action_full()}}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="account_ids" id="account_ids" value="">
                        <input type="hidden" name="hidden_absense_date" id="hidden_absense_date" value="">

                        <a class="btn btn-default" href="/cabinet/daily-attendance">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Attendance</button>
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

    $(".account_entity_id").checkboxX({
        iconChecked: "<b>X</b>",
        threeState: false
    });

    // // create datatale with checkbox column unsortable
    // $('#attendance-table').DataTable( {
    //    "aoColumnDefs": [
    //        { 'bSortable': false, 'aTargets': [ 0 ] }
    //     ],
    //     "bPaginate": false,
    //     "autoWidth": false
    // });

    // when the account types dropdown changes redirect
    $('#account_type_entity_id, #month_id').change(function() {
        updateQueryString();
    });

    function updateQueryString() {
        window.location.href = window.location.href.split('?')[0] + getQueryString();
    }

    // get the query string
    function getQueryString() {
        var aei = $('#account_type_entity_id option:selected').val();
        var mi = $('#month_id option:selected').val();

        var items = [];
        if (aei != "none") {
            items.push('aei='+aei);
        }
        if (mi != "none") {
            items.push('mi='+mi);
        }
        var queryString = items.join('&');
        if (queryString.length > 1) {
            return '?' + queryString;
        }
        return '';
    }

    $('#update-attendance-form').submit(function() {
        var date = $('#absense_date').text();
        $('#hidden_absense_date').val(date);

        var accountIds = $('.account_entity_id').map(function() {
            if ($(this).val() == 1) {
                return $(this).attr('data-accountId') + '-1';
            } else {
                return $(this).attr('data-accountId') + '-0';;
            }
        }).get();

        $('#account_ids').val(accountIds.join(','));

        return true;
    });
</script>
@endsection
