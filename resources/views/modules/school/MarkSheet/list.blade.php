@extends('layout.cabinet')

@section('title', 'Mark Sheet')

@section('content')

        <div class="panel-group sch_class">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th-list"></i>
                    <h3>Mark Sheet</h3>
                </div>
                <div class="panel-body">

                    @include('commons.errors')

                    <!-- filter the exams -->
                    <form class="form-horizontal" style="margin-bottom:-15px;" action="" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="exam_entity_id">Exam</label>
                                    <div class="col-md-9">
                                        <select id="exam_entity_id" class="form-control" name="exam_entity_id">
                                            <option value="none">Select an exam..</option>
                                            @foreach($markSheet->examDropdown() as $option)
                                                <option {{activeSelect($option['exam_entity_id'], 'eid')}} value="{!! $option['exam_entity_id'] !!}">{!! $option['exam'] !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <hr/>

                   <table class="table table-striped table-bordered table-hover" data-datatable>
                    <thead>
                        <tr>
                            <th>Class <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Subject <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Locked <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

            @foreach($markSheet->getGrid() as $item)
            <tr class="mark-sheet-tr">
                <td class="mark-sheet-td" data-examid="{{$item['exam_entity_id']}}" >
                    {{$item['class_name']}}
                </td>
                <td>{{$item['subject']}}</td>
                <td>{{$item['locked']}}</td>
                <td>
                    @if (is_locked($item['locked']))
                        <a class="btn btn-default formConfirm" href="{{url("/cabinet/mark-sheet/unlock?eid={$item['exam_entity_id']}&cid={$item['class_entity_id']}&sid={$item['subject_entity_id']}")}}"
                           title="Unlock"
                           data-title="Unlock Mark Sheet"
                           data-message="Are you sure to unlock the selected record?"
                        >Unlock
                        </a>
                    @else
                        <a class="btn btn-default" href="{{url("/cabinet/mark-sheet/edit?eid={$item['exam_entity_id']}&cid={$item['class_entity_id']}&sid={$item['subject_entity_id']}")}}" title="Edit">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit
                        </a>
                        <a class="btn btn-default formConfirm" href="{{url("/cabinet/mark-sheet/lock?eid={$item['exam_entity_id']}&cid={$item['class_entity_id']}&sid={$item['subject_entity_id']}")}}"
                           title="Lock"
                           data-title="Lock Mark Sheet"
                           data-message="Are you sure to lock the selected record?"
                        >
                            <span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Lock
                        </a>
                    @endif

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

    // reload the page when selecting an exam
    $('#exam_entity_id').change(function() {
        if (this.value == 'none') {
            window.location.href = "/cabinet/mark-sheet";
        } else {
            window.location.href = "/cabinet/mark-sheet?eid=" + this.value;
        }
    });

</script>
@endsection
