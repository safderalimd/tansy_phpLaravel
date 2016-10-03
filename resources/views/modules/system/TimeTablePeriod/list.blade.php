@extends('layout.cabinet')

@section('title', 'Time Table Period')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
    	<div class="panel-heading">
        	<i class="glyphicon glyphicon-th-list"></i>
        	<h3>Time Table Period</h3>
        </div>
        <div class="panel-body">

            <div class="lookup-error-message alert alert-danger" style="display:none;">
                <ul>
                    <li></li>
                </ul>
            </div>

            <div id="select-template" style="display:none;">
                <select class="form-control" name="">
                    <option value="none">Select a period type..</option>
                    @foreach($period->periodType() as $option)
                        <option value="{{ $option['period_type_id'] }}">{{ $option['period_type'] }}</option>
                    @endforeach
                </select>
            </div>

            <form class="form-horizontal" id="time-table-period-form" action="/cabinet/time-table-period" method="POST">

                <div class="row">
                    <div class="col-md-12">
                        <table class="time-table-period-table table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Period Name</th>
                                    <th>Period Type</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Reporting Order</th>
                                    <th>Active</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($period->rows() as $row)
                                <tr class="time-table-period-row">
                                    <td class="td-period_name">{{$row['period_name']}}</td>
                                    <td class="td-period_type" data-typeId="{{$row['period_type_id']}}">{{$row['period_type']}}</td>
                                    <td class="td-start_time" data-startTime="{{$row['start_time']}}">{{$row['start_time']}}</td>
                                    <td class="td-end_time" data-endTime="{{$row['end_time']}}">{{$row['end_time']}}</td>
                                    <td class="td-reporting_order">{{$row['reporting_order']}}</td>
                                    <td class="td-active">
                                        @if ($row['active'] == 1) Yes @else No @endif
                                    </td>
                                    <td>
                                        <button type="button" class="edit-button btn btn-default">Edit</button>
                                        <button data-loading-text="Saving..." data-keyid="{{$row['period_id']}}" type="button" style="display:none;" class="save-button btn btn-default">Save</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                   <div class="col-md-12 text-left">
                        <button type="button" id="add-new-row" class="btn btn-primary">Add New Row</button>
                    </div>
                </div>

            </form>

		    @include('commons.modal')

        </div>
    </div>
</div>

@endsection

@section('styles')
<style type="text/css">
    .td-period_name input,
    .td-period_type input,
    .td-reporting_order input {
        max-width: 200px;
    }
</style>
@endsection

@section('scripts')
<script type="text/javascript">

    function timeHtml(time) {
        var timeHtml = '';
        timeHtml += '<div class="input-group datetimepicker">';
        timeHtml += '    <input class="form-control datetimepicker" type="text" name="" value="'+time+'">';
        timeHtml += '    <span class="input-group-addon" style="cursor:pointer;">';
        timeHtml += '        <span class="glyphicon glyphicon-time"></span>';
        timeHtml += '    </span>';
        timeHtml += '</div>';
        return timeHtml;
    }

    $('.time-table-period-table').on('click', '.edit-button', function() {
        var row = $(this).closest('.time-table-period-row');
        $('.save-button', row).show();
        $(this).hide();

        var periodName = $('.td-period_name', row).text();
        var periodTypeId = $('.td-period_type', row).attr('data-typeId');
        var startTime = $('.td-start_time', row).text();
        var endTime = $('.td-end_time', row).text();
        var active = $('.td-active', row).text();
        active = (active.indexOf('Yes') !== -1) ? true : false;
        var reportingOrder = $('.td-reporting_order', row).text();

        $('.td-period_name', row).html($('<input class="form-control" type="text" value=""/>').val(periodName));
        $('.td-period_type', row).html($($('#select-template').html()).val(periodTypeId));
        $('.td-start_time', row).html($(timeHtml(startTime)));
        $('.td-end_time', row).html($(timeHtml(endTime)));
        $('.datetimepicker', row).datetimepicker({format:'HH:mm:ss'});
        if (active) {
            $('.td-active', row).html($('<input class="checkbox" checked="checked" type="checkbox">'));
        } else {
            $('.td-active', row).html($('<input class="checkbox" type="checkbox">'));
        }
        $('.td-reporting_order', row).html($('<input class="form-control" type="text" value="">').val(reportingOrder));
    });

    function makeRowUneditable(row) {
        $('.save-button', row).hide();
        $('.edit-button', row).show();

        var period_name = $('.td-period_name input', row).val();
        var period_type = $('.td-period_type select option:selected', row).text();
        if (period_type == 'none') {
            period_type = '';
        }
        var start_time = $('.td-start_time input', row).val();
        var end_time = $('.td-end_time input', row).val();
        var reporting_order = $('.td-reporting_order input', row).val();
        var active = $('.td-active input', row).is(':checked');
        if (active == true) {
            active = 'Yes';
        } else {
            active = 'No';
        }

        $('.td-period_name', row).html(period_name);
        $('.td-period_type', row).html(period_type);
        $('.td-start_time', row).html(start_time);
        $('.td-end_time', row).html(end_time);
        $('.td-reporting_order', row).html(reporting_order);
        $('.td-active', row).html(active);
    }

    $('.time-table-period-table').on('click', '.save-button', function() {
        var row = $(this).closest('.time-table-period-row');
        var periodId = $(this).attr('data-keyid');
        var isNewRecord = $(this).attr('data-newrecord');
        var saveButton = this;

        var postUrl = '/cabinet/time-table-period/update';
        if (isNewRecord) {
            postUrl = '/cabinet/time-table-period/store';
        }

        var period_name = $('.td-period_name input', row).val();
        var period_type_id = $('.td-period_type select option:selected', row).val();
        if (period_type_id=='none') {
            alert('Please choose a period type.');
            return;
        }
        var start_time = $('.td-start_time input', row).val();
        var end_time = $('.td-end_time input', row).val();
        var reporting_order = $('.td-reporting_order input', row).val();
        var active = $('.td-active input', row).is(':checked');

        $('.td-period_type', row).attr('data-typeId', period_type_id);
        $('.td-start_time', row).attr('data-startTime', start_time);
        $('.td-end_time', row).attr('data-endTime', end_time);

        $(saveButton).button('loading');

        $.ajax({
            type: "POST",
            url: postUrl,
            data: {
                'period_id': periodId,
                'period_name': period_name,
                'period_type_id': period_type_id,
                'start_time': start_time,
                'end_time': end_time,
                'reporting_order': reporting_order,
                'active': active
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

    $('#add-new-row').on('click', function() {
        var period_name = '<td class="td-period_name"><input class="form-control" type="text"></td>';
        var period_type = '<td class="td-period_type">'+$('#select-template').html()+'</td>';
        var start_time = '<td class="td-start_time">'+timeHtml('')+'</td>';
        var end_time = '<td class="td-end_time">'+timeHtml('')+'</td>';
        var reporting_order = '<td class="td-reporting_order"><input class="form-control" type="text"></td>';
        var active = '<td class="td-active"><input class="checkbox" checked="checked" type="checkbox"></td>';

        var saveButton = '<td><button type="button" data-newrecord="true" data-loading-text="Saving..." class="save-button btn btn-default">Save</button></td>';

        var html = period_name + period_type + start_time + end_time + reporting_order + active + saveButton;
        $('.time-table-period-table tbody').append('<tr class="time-table-period-row">'+html+'</tr>');

        $('.datetimepicker', $('.time-table-period-table:last')).datetimepicker({format:'HH:mm:ss'});
    });
</script>
@endsection
