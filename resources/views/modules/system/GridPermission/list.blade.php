@extends('layout.cabinet')

@section('title', 'Grid Permission')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
    	<div class="panel-heading">
        	<i class="glyphicon glyphicon-th-list"></i>
        	<h3>Grid Permission</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" action="" method="POST">
                <div class="row">
                    <div class="col-md-12">

                        <div class="form-group">
                            <label class="col-md-2 control-label" for="grid-filter">Grid</label>
                            <div class="col-md-3">
                                <select id="grid-filter" class="form-control" name="grid-filter">
                                    <option value="none">Select a grid..</option>
                                    @foreach($grid->customGrids() as $option)
                                        <option {{ activeSelect($option['screen_id'], 'gsi') }} value="{{ $option['screen_id'] }}">{{ $option['screen_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label" for="security-account">Security Account</label>
                            <div class="col-md-3">
                                <select id="security-account" class="form-control" name="security-account">
                                    <option value="none">Select a security account..</option>
                                    @foreach($grid->securityGroup() as $option)
                                        <option {{ activeSelect($option['group_entity_id'], 'gei') }} value="{{ $option['group_entity_id'] }}">{{ $option['group_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-md-6">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Field Name</th>
                                <th>Visible</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grid->rows() as $item)
                            <tr>
                                <td>{{$item['ui_label']}}</td>
                                <td class="text-center">
                                    <input type="checkbox" data-screenid="{{$item['screen_id']}}" class="checkbox-screen-id" name="checkbox_screen_id" value="{{$item['screen_id']}}">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
               <div class="col-md-2 col-md-offset-4 text-right">
                    <button type="submit" id="save-grid-permission-submit" class="btn btn-primary">
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                        Save Permissions
                    </button>
                </div>
            </div>

		    @include('commons.modal')

        </div>
    </div>
</div>

@endsection


@section('scripts')
<script type="text/javascript">

    $('#grid-filter, #security-account').change(function() {
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
        if (gei != "none") {
            items.push('gei='+gei);
        }

        var queryString = items.join('&');
        if (queryString.length > 1) {
            return '?' + queryString;
        }
        return '';
    }

    // // Checkbox table header - for this page, toggle all checkboxes
    // $('#toggle-subjects').change(function() {
    //     if($(this).is(":checked")) {
    //         $('.student-entity-id').prop('checked', true);
    //     } else {
    //         $('.student-entity-id').prop('checked', false);
    //     }
    // });

    // // Disable/Enable Move Button depending if checkboxes are selected
    // $('.student-entity-id, #toggle-subjects').change(function() {
    //     if ($('.student-entity-id:checked').length > 0) {
    //         $('#move-students-submit').prop('disabled', false);
    //     } else {
    //         $('#move-students-submit').prop('disabled', true);
    //     }
    // });

    // // When submitting the form, prepend all selected checkboxes
    // $('#move-students-form').submit(function() {
    //     if (! $('#move-students-form').valid()) {
    //         return false;
    //     }

    //     var studentIds = $('.student-entity-id:checked').map(function() {
    //         return this.value;
    //     }).get();

    //     if (studentIds.length == 0) {
    //         alert("No students are selected.");
    //         return false;
    //     }

    //     $('#class_student_ids').val(studentIds.join(','));

    //     return true;
    // });

    // $('#move-students-form').validate({
    //     rules: {
    //         move_to_fiscal_year_entity_id: {
    //             requiredSelect: true
    //         },
    //         move_to_class_entity_id: {
    //             requiredSelect: true,
    //             notEqualTo: '#grid-filter'
    //         }
    //     },
    //     messages: {
    //         move_to_class_entity_id: {
    //             notEqualTo: "Please select a different class."
    //         }
    //     }
    // });

</script>
@endsection
