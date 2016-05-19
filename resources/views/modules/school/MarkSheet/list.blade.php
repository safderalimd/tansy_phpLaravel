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

                    <div class="row" style="margin-bottom:-20px;">
                        <div class="cold-md-4">
                            <div class="form-horizontal">
                                <div class="col-md-2 text-center">
                                    <?php
                                        $exams = $markSheet->exam();
                                        array_unshift($exams, [
                                            "exam_entity_id" => "none",
                                            "exam" => "Select an exam",
                                        ]);
                                    ?>
                                    @include('commons.select', [
                                        'label'   => 'Exam' ,
                                        'name'    => 'exam_entity_id',
                                        'options' => $exams,
                                        'keyId'   => 'exam_entity_id',
                                        'keyName' => 'exam',
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
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

            @foreach($markSheet->markSheetGrid() as $item)
            <tr style="display:none;" class="mark-sheet-tr">
                <td class="mark-sheet-td" data-examid="{{$item['exam_entity_id']}}" >
                    {{$item['class_name']}}
                </td>
                <td>{{$item['subject']}}</td>
                <td>{{$item['locked']}}</td>
                <td>
                    @if (is_locked($item['locked']))
                        <a class="btn btn-default formConfirm" href="{{url("/cabinet/mark-sheet/unlock?eid={$item['exam_entity_id']}&cid={$item['class_entity_id']}&sid={$item['subject_entity_id']}")}}"
                           title="Unclock"
                           data-title="Unclock Mark Sheet"
                           data-message="Are you sure to unlock the selected record?"
                        >Unlock
                        </a>
                    @else
                        <a class="btn btn-default" href="{{url("/cabinet/mark-sheet/edit/{$item['subject_entity_id']}")}}" title="Edit">
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

    // When selecting an exam, display rows only for that exam
    $('#exam_entity_id').change(function() {
        $('.mark-sheet-td').parents('tr.mark-sheet-tr').hide();
        var examId = this.value;
        if (examId != "none") {
            $('.mark-sheet-td').each(function() {
                if ($(this).attr('data-examid') == examId) {
                    $(this).parents('tr.mark-sheet-tr').show();
                }
            });
        }
    });

</script>
@endsection
