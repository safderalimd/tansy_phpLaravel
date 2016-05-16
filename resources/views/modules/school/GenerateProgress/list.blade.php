@extends('layout.cabinet')

@section('title', 'Generate Progress')

@section('content')

    <div class="panel-group sch_class">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-th-list"></i>
                <h3>Generate Progress</h3>
            </div>
            <div class="panel-body">

                @include('commons.errors')


                <form class="form-horizontal" action="{{url("/cabinet/generate-progress/generate-progress-for-all-classes")}}" method="POST">
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-md-2">
                            @include('commons.select', [
                                'label'   => 'Exam' ,
                                'name'    => 'exam_entity_id',
                                'options' => $progress->exam(),
                                'keyId'   => 'exam_entity_id',
                                'keyName' => 'exam',
                            ])
                        </div>
                        <div class="col-md-10">
                            <button class="btn btn-primary pull-right" type="submit">Generate Progress for all Classes</button>
                        </div>
                    </div>
                </form>

                <hr/>

               <table class="table table-striped table-bordered table-hover" data-datatable>
                <thead>
                    <tr>
                        <th>Class <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Status <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Class Report</th>
                        <th>Student Report</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
        @foreach($progress->generateProgressGrid() as $item)
        <tr>
            <!-- class_name, subject, locked, progress_status, last_upload_modified_date, exam_entity_id, class_entity_id, subject_entity_id -->
            <?php
                if (strtolower($item['progress_status']) == 'generate successfully') {
                    $generated = true;
                } else {
                    $generated = false;
                }
            ?>
            <td>{{$item['class_name']}}</td>
            <td>{{$item['progress_status']}}</td>
            <td>
                @if ($generated)
                    <a class="btn btn-default" href="{{url("/cabinet/generate-progress/print?exam_entity_id={$item['exam_entity_id']}&subject_entity_id={$item['subject_entity_id']}")}}" title="Print">Print</a>
                @endif
            </td>
            <td>
                @if ($generated)
                    <a class="btn btn-default" href="{{url("/cabinet/generate-progress/print?exam_entity_id={$item['exam_entity_id']}&subject_entity_id={$item['subject_entity_id']}")}}" title="Print">Print</a>
                @endif
            </td>
            <td>
                @if ($generated)
                    <a class="btn btn-default" href="{{url("/cabinet/generate-progress/re-generate?exam_entity_id={$item['exam_entity_id']}&subject_entity_id={$item['subject_entity_id']}")}}" title="Re - generate">Re - generate</a>
                @else
                    <a class="btn btn-default" href="{{url("/cabinet/generate-progress/generate?exam_entity_id={$item['exam_entity_id']}&subject_entity_id={$item['subject_entity_id']}")}}" title="Generate">Generate</a>
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
