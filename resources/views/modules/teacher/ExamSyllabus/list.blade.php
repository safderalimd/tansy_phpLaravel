@extends('layout.cabinet')

@section('title', 'Exam Syllabus')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Exam Syllabus</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" action="" method="POST">

                <div class="form-group">
                    <label class="col-md-1 control-label" for="exam_entity_id">Exam</label>
                    <div class="col-md-4">
                        <select id="exam_entity_id" class="form-control" name="eei">
                            <option value="none">Select an exam..</option>
                            @foreach($syllabus->exam() as $option)
                                <option {{ activeSelect($option['exam_entity_id'], 'eei') }} value="{{ $option['exam_entity_id'] }}">{{ $option['exam'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-1 control-label" for="class_entity_id">Subject</label>
                    <div class="col-md-4">
                        <select id="class_entity_id" class="form-control" name="cei">
                            <option value="none">Select a class..</option>
                            @foreach($syllabus->classes() as $option)
                                <option {{ activeSelect($option['class_entity_id'], 'cei') }} value="{{ $option['class_entity_id'] }}">{{ $option['class_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </form>

            <table class="table table-striped table-bordered table-hover" data-datatable>
                <thead>
                    <tr>
                        <th>Class Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Subject <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Syllabus Provided <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($syllabus->rows() as $item)
                    <tr>
                        <td>{{$item['class_name']}}</td>
                        <td>{{$item['subject']}}</td>
                        <td>{{$item['syllabus_provided']}}</td>
                        <td>
                            <a class="btn btn-default" href="{{url("/cabinet/exam-syllabus/edit/{$item['exam_schedule_id']}").query_string()}}" title="Edit">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            </a>
                            <a class="btn btn-default formConfirm" href="{{url("/cabinet/exam-syllabus/delete/{$item['exam_schedule_id']}").query_string()}}"
                               title="Delete"
                               data-title="Delete Exam Syllabus"
                               data-message="Are you sure to delete the selected record?"
                            >
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @include('commons.modal')

        </div>
    </div>
</div>
@endsection


@section('scripts')
<script type="text/javascript">

    $('#exam_entity_id, #class_entity_id').change(function() {
        updateQueryString();
    });

    function updateQueryString() {
        window.location.href = window.location.href.split('?')[0] + getQueryString();
    }

    function getQueryString() {
        var eei = $('#exam_entity_id option:selected').val();
        var cei = $('#class_entity_id option:selected').val();

        var items = [];
        if (eei != "none") {
            items.push('eei='+eei);
        }
        if (cei != "none") {
            items.push('cei='+cei);
        }

        var queryString = items.join('&');
        if (queryString.length > 1) {
            return '?' + queryString;
        }
        return '';
    }

</script>
@endsection
