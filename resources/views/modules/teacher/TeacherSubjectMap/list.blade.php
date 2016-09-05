@extends('layout.cabinet')

@section('title', 'Teacher Subject Map')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
    	<div class="panel-heading">
        	<i class="glyphicon glyphicon-th-list"></i>
        	<h3>Teacher Subject Map</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" action="" method="POST">
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="individual_entity_id">Employee</label>
                            <div class="col-md-6">
                                <select id="individual_entity_id" class="form-control" name="eid">
                                    <option value="none">Select an employee..</option>
                                    @foreach($teacher->orgEmployees() as $option)
                                        <option {{ activeSelect($option['individual_entity_id'], 'eid') }} value="{{ $option['individual_entity_id'] }}">{{ $option['individual_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="subject_entity_id">Subject</label>
                            <div class="col-md-6">
                                <select id="subject_entity_id" class="form-control" name="sid">
                                    <option value="none">Select a subject..</option>
                                    @foreach($teacher->subject() as $option)
                                        <option {{ activeSelect($option['subject_entity_id'], 'sid') }} value="{{ $option['subject_entity_id'] }}">{{ $option['subject'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6">

                        <table class="table table-striped table-bordered table-hover" data-datatable>
                            <thead>
                                <tr>
                                    <th>Class <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                                    <th>Mapped</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $rows = $teacher->rows(); ?>
                                @foreach($rows as $item)
                                <tr>
                                    <td>{{$item['class_name']}}</td>
                                    <td>
                                        @if ($item['mapped_flag'] == 'mapped')
                                            <input type="checkbox" class="teacher-subject-map" checked="checked" name="teacher_subject_map" value="{{$item['class_entity_id']}}">
                                        @else
                                            <input type="checkbox" class="teacher-subject-map" name="teacher_subject_map" value="{{$item['class_entity_id']}}">
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

                <br/>

                <div class="row grid_footer">
                    <div class="col-md-6">
                        @if (count($rows))
                            <button type="submit" id="teacher-subject-map-submit" class="grid_btn btn btn-primary pull-right">Save</button>
                        @else
                            <button type="submit" id="teacher-subject-map-submit" disabled="disabled" class="grid_btn btn btn-primary pull-right">Save</button>
                        @endif

                        <a style="margin-right:10px;" href="{{ url("/cabinet/teacher-subject-map")}}" class="btn btn-default cancle_btn pull-right">Cancel</a>
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

    $('#individual_entity_id, #subject_entity_id').change(function() {
        updateQueryString();
    });

    function updateQueryString() {
        window.location.href = window.location.href.split('?')[0] + getQueryString();
    }

    // get the query string
    function getQueryString() {
        var eid = $('#individual_entity_id option:selected').val();
        var sid = $('#subject_entity_id option:selected').val();

        var items = [];
        if (eid != "none") {
            items.push('eid='+eid);
        }
        if (sid != "none") {
            items.push('sid='+sid);
        }

        var queryString = items.join('&');
        if (queryString.length > 1) {
            return '?' + queryString;
        }
        return '';
    }

    // When submitting the form, prepend all selected checkboxes
    $('#move-students-form').submit(function() {
        if (! $('#move-students-form').valid()) {
            return false;
        }

        var studentIds = $('.student-entity-id:checked').map(function() {
            return this.value;
        }).get();

        if (studentIds.length == 0) {
            alert("No students are selected.");
            return false;
        }

        $('#class_student_ids').val(studentIds.join(','));

        return true;
    });

    $('#move-students-form').validate({
        rules: {
            move_to_fiscal_year_entity_id: {
                requiredSelect: true
            },
            move_to_class_entity_id: {
                requiredSelect: true,
                notEqualTo: '#class-entity-id-filter'
            }
        },
        messages: {
            move_to_class_entity_id: {
                notEqualTo: "Please select a different class."
            }
        }
    });

</script>
@endsection
