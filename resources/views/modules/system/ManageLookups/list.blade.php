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

            @include('commons.errors')

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
                                @foreach([] as $item)
                                <tr class="manage-lookups-row">
                                    <td class="row-ui-label">{{$item['ui_label']}}</td>
                                    <td style="max-width:150px;width:150px;">
                                        <input data-rule-number="true" data-rule-min="0" class="input-column-position form-control" type="text" name="" value="{{$item['column_position']}}">
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" @if($item['visible'] == 1) checked="checked" @endif class="checkbox-visible-id" name="checkbox_visible_id" value="">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                   <div class="col-md-6 text-right">

                        <input type="hidden" id="uiLabel-order-visible-list" name="uiLabel_order_visible_list" value="">

                        <a href="{{ url("/cabinet/manage-lookups")}}" class="btn btn-default cancle_btn">Cancel</a>
                        <button type="submit" id="save-manage-lookups-submit" class="btn btn-primary">
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

    // When submitting the form, prepend all selected checkboxes
    $('#manage-lookups-form').submit(function() {
        if (! $('#manage-lookups-form').valid()) {
            return false;
        }

        var checkboxes = $('.manage-lookups-row').map(function() {

            var label = $('.row-ui-label', $(this)).text();

            var checkbox = $('.checkbox-visible-id', $(this));
            var checked = 0;
            if ($(checkbox).is(":checked")) {
                checked = 1;
            }

            var position = $('.input-column-position', $(this)).val();

            return label + '|' + position + '|' + checked;
        }).get();

        $('#uiLabel-order-visible-list').val(checkboxes.join(','));

        return true;
    });

    $('#manage-lookups-form').validate();

</script>
@endsection
