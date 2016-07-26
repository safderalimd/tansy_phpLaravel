@extends('layout.cabinet')

@section('title', 'Custom Fields')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
    	<div class="panel-heading">
        	<i class="glyphicon glyphicon-th-list"></i>
        	<h3>Custom Fields</h3>
            @if (isset($fields->gsi) && is_numeric($fields->gsi))
                <a href="{{url('/cabinet/custom-fields/create/')}}?gsi={{$fields->gsi}}" class="btn pull-right btn-default">Add new record</a>
            @endif
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" id="grid-setup-form" action="/cabinet/custom-fields" method="POST">

                <div class="row">
                    <div class="col-md-12">

                        <div class="form-group">
                            <label class="col-md-2 control-label" for="grid-filter">Entity</label>
                            <div class="col-md-3">
                                <select id="grid-filter" class="form-control" name="gird_filter">
                                    <option value="none">Select an entity..</option>
                                    @foreach($fields->entities() as $option)
                                        <option {{ activeSelect($option['screen_id'], 'gsi') }} value="{{ $option['screen_id'] }}">{{ $option['screen_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>UI Label</th>
                                    <th>Active</th>
                                    <th>Input Type</th>
                                    <th>Data Type</th>
                                    <th>Sequence</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>


                <?php
                    $inputTypes = $fields->fieldInputType();
                    $dataTypes = $fields->fieldDataType();
                ?>
                @foreach($fields->rows() as $row)
                    @if ($row['visible_in_grid'] == 1)
                        <tr>
                            <td>{{$row['ui_label']}}</td>
                            <td>
                                @if ($row['active'] == 1)
                                    Yes
                                @else
                                    No
                                @endif
                            </td>
                            <td>
                                @foreach ($inputTypes as $type)
                                    @if ($type['input_type_id'] == $row['input_type_id'])
                                        {{$type['input_type']}}
                                        <?php break; ?>
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach ($dataTypes as $type)
                                    @if ($type['data_type_id'] == $row['data_type_id'])
                                        {{$type['data_type']}}
                                        <?php break; ?>
                                    @endif
                                @endforeach
                            </td>
                            <td>{{$row['order_sequence']}}</td>
                            <td>
                                <a class="btn btn-default" href="{{url("/cabinet/custom-fields/edit/{$row['custom_field_id']}")}}?gsi={{$fields->gsi}}" title="Edit">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                </a>
                            </td>
                        </tr>
                    @endif
                @endforeach


                            </tbody>
                        </table>
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

</script>
@endsection
