@extends('layout.cabinet')

@section('title', 'Manage Lookups')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
    	<div class="panel-heading">
        	<i class="glyphicon glyphicon-th-list"></i>
        	<h3>Manage Lookups</h3>
        </div>
        <div class="panel-body">

            <div class="lookup-error-message alert alert-danger" style="display:none;">
                <ul>
                    <li></li>
                </ul>
            </div>

            <form class="form-horizontal" id="manage-lookups-form" action="/cabinet/manage-lookups" method="POST">

                <div class="row">
                    <div class="col-md-12">

                        <div class="form-group">
                            <label class="col-md-2 control-label" for="lookup-name">Lookup Name</label>
                            <div class="col-md-3">
                                <select id="lookup-name" class="form-control" name="filter_screen_id">
                                    <option value="none">Select a lookup..</option>
                                    @foreach($lookups->lookups() as $option)
                                        <option {{ activeSelect($option['lookup_id'], 'lki') }} value="{{ $option['lookup_id'] }}">{{ $option['lookup_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <table class="lookup-table table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <?php $header = $lookups->firstRow(); ?>
                                    @if (isset($header['description']))
                                        <th>Value</th>
                                    @endif
                                    @if (isset($header['active']))
                                        <th>Active</th>
                                    @endif
                                    @if (isset($header['reporting_order']))
                                        <th>Reporting Order</th>
                                    @endif
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lookups->rows() as $row)
                                <tr class="manage-lookups-row">
                                    @if (isset($header['description']))
                                        <td class="td-description">{{$row['description']}}</td>
                                    @endif
                                    @if (isset($header['active']))
                                        <td class="td-active">{{$row['active']}}</td>
                                    @endif
                                    @if (isset($header['reporting_order']))
                                        <td class="td-reporting_order">{{$row['reporting_order']}}</td>
                                    @endif
                                    <td>
                                        <button type="button" class="edit-button btn btn-default">Edit</button>
                                        <button data-loading-text="Saving..." data-keyid="{{$row['primary_key_id']}}" type="button" style="display:none;" class="save-button btn btn-default">Save</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($lookups->hasAddButton())
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

@section('styles')
<style type="text/css">
    .td-description input {
        max-width: 350px;
    }
    .td-reporting_order input {
        max-width: 200px;
    }
</style>
@endsection

@section('scripts')
<script type="text/javascript">

    $('#lookup-name').change(function() {
        updateQueryString();
    });

    function updateQueryString() {
        window.location.href = window.location.href.split('?')[0] + getQueryString();
    }

    // get the query string
    function getQueryString() {
        var lki = $('#lookup-name option:selected').val();
        var gei = $('#security-account option:selected').val();

        var items = [];
        if (lki != "none") {
            items.push('lki='+lki);
        }

        var queryString = items.join('&');
        if (queryString.length > 1) {
            return '?' + queryString;
        }
        return '';
    }

    $('.lookup-table').on('click', '.edit-button', function() {
        var row = $(this).closest('.manage-lookups-row');
        $('.save-button', row).show();
        $(this).hide();

        var description = $('.td-description', row).text();
        var active = $('.td-active', row).text();
        var reporting_order = $('.td-reporting_order', row).text();

        $('.td-description', row).html($('<input class="form-control" type="text" value="">').val(description));

        if (active == '1') {
            $('.td-active', row).html($('<input class="checkbox" checked="checked" type="checkbox">'));
        } else {
            $('.td-active', row).html($('<input class="checkbox" type="checkbox">'));
        }

        $('.td-reporting_order', row).html($('<input class="form-control" type="text" value="">').val(reporting_order));
    });

    function makeRowUneditable(row) {
        $('.save-button', row).hide();
        $('.edit-button', row).show();

        var description = $('.td-description input', row).val();
        var active = $('.td-active', row).is(':checked');
        var reporting_order = $('.td-reporting_order input', row).val();

        $('.td-description', row).html(description);
        if (active == true) {
            active = 1;
        } else {
            active = 0;
        }
        $('.td-active', row).html(active);
        $('.td-reporting_order', row).html(reporting_order);
    }

    $('.lookup-table').on('click', '.save-button', function() {
        var row = $(this).closest('.manage-lookups-row');
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

    $('#add-new-row').on('click', function() {
        var description = '<td class="td-description"><input class="form-control" type="text" value=""></td>';
        var active = '<td class="td-active"><input class="checkbox" type="checkbox"></td>';
        var reportingOrder = '<td class="td-reporting_order"><input class="form-control" type="text" value=""></td>';

        if ($('.td-description').length == 0) {
            description = '';
        }
        if ($('.td-active').length == 0) {
            active = '';
        }
        if ($('.td-reporting_order').length == 0) {
            reportingOrder = '';
        }

        var saveButton = '<td><button type="button" data-newrecord="true" data-loading-text="Saving..." class="save-button btn btn-default">Save</button></td>';

        var html = description + active + reportingOrder + saveButton;

        $('.lookup-table tbody').append('<tr class="manage-lookups-row">'+html+'</tr>');
    });
</script>
@endsection
