@extends('layout.cabinet')

@section('title', 'Grid Setup')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
    	<div class="panel-heading">
        	<i class="glyphicon glyphicon-th-list"></i>
        	<h3>Grid Setup</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" id="grid-setup-form" action="/cabinet/grid-setup" method="POST">

                <div class="row">
                    <div class="col-md-12">

                        <div class="form-group">
                            <label class="col-md-2 control-label" for="grid-filter">Grid</label>
                            <div class="col-md-3">
                                <select id="grid-filter" class="form-control" name="filter_screen_id">
                                    <option value="none">Select a grid..</option>
                                    @foreach($grid->customGrids() as $option)
                                        <option {{ activeSelect($option['screen_id'], 'gsi') }} value="{{ $option['screen_id'] }}">{{ $option['screen_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Field Name</th>
                                    <th>Order</th>
                                    <th>Visible</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{d($grid->rows())}}
                                @foreach([] as $item)
                                <tr>
                                    <td>{{$item['ui_label']}}</td>
                                    <td class="text-center">
                                        <input type="checkbox" data-label="{{$item['ui_label']}}" data-screenid="{{$item['screen_id']}}" class="checkbox-screen-id" name="checkbox_screen_id" value="">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                   <div class="col-md-2 col-md-offset-4 text-right">

                        <input type="hidden" id="uiLabel-order-visible-list" name="uiLabel_order_visible_list" value="">

                        <button type="submit" id="save-grid-setup-submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                            Save Setup
                        </button>
                    </div>
                </div>

            </form>

		    @include('commons.modal')

        </div>
    </div>
</div>

@endsection


@section('scripts')
<script type="text/javascript">

    $('#grid-filter').change(function() {
        updateQueryString();
    });

    function updateQueryString() {
        window.location.href = window.location.href.split('?')[0] + getQueryString();
    }

    // get the query string
    function getQueryString() {
        var gsi = $('#grid-filter option:selected').val();
        var gei = $('#security-account option:selected').val();

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

    // When submitting the form, prepend all selected checkboxes
    $('#grid-setup-form').submit(function() {
        if (! $('#grid-setup-form').valid()) {
            return false;
        }

        var checkboxes = $('.checkbox-screen-id').map(function() {
            var checked = 0;
            if ($(this).is(":checked")) {
                checked = 1;
            }
            return $(this).attr('data-label') + '|' + checked;
        }).get();

        $('#uiLabel-order-visible-list').val(checkboxes.join(','));

        return true;
    });

    $('#grid-setup-form').validate({
        rules: {
            filter_screen_id: {
                requiredSelect: true
            }
        }
    });

</script>
@endsection
