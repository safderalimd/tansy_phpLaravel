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
                                    @include('commons.select', [
                                        'label'   => 'Exam' ,
                                        'name'    => 'exam_entity_id',
                                        'options' => $markSheet->exam(),
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
            <tr>
                <td>{{$item['class_name']}}</td>
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
