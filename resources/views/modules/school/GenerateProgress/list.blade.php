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

                <!-- filter the rows -->
                <form class="form-horizontal" style="margin-bottom:-15px;" action="{{url_with_query("/cabinet/generate-progress/generate-progress-for-all-classes")}}" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="exam_entity_id">Exam</label>
                                <div class="col-md-10">
                                    <select id="exam_entity_id" class="form-control" name="exam_entity_id">
                                        <option value="none">Select an exam..</option>
                                        @foreach($progress->examDropdown() as $option)
                                            <option {{ activeSelect($option['exam_entity_id'], 'eid') }} value="{{ $option['exam_entity_id'] }}">{{ $option['exam'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                           <button class="btn btn-primary grid_btn" type="submit">Generate Progress for all Classes</button>
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
                    <?php
                        $pdfLabel = pdf_label();
                    ?>

        @foreach($progress->generateFilteredProgressGrid() as $item)
        <tr>
            <?php
                if (strtolower($item['progress_status']) == 'generated') {
                    $generated = true;
                } else {
                    $generated = false;
                }
            ?>
            <td>{{$item['class_name']}}</td>
            <td>{{$item['progress_status']}}</td>
            <td>
                @if ($generated)
                    <a class="btn btn-default" target="_blank" href="{{url("/cabinet/pdf---class-progress/pdf?ei={$item['exam_entity_id']}&ci={$item['class_entity_id']}")}}" title="{{$pdfLabel}}">{{$pdfLabel}}</a>
                    <a class="btn btn-default" target="_blank" href="{{url("/cabinet/pdf---class-progress/csv?ei={$item['exam_entity_id']}&ci={$item['class_entity_id']}")}}" title="CSV">CSV</a>
                @endif
            </td>
            <td>
                @if ($generated)
                    @if (isset($item['student_report_version']) && $item['student_report_version'] == 'V-0002')
                        <a class="btn btn-default" target="_blank" href="{{url("/cabinet/pdf---student-progress-v2/pdf?ei={$item['exam_entity_id']}&ci={$item['class_entity_id']}")}}" title="{{$pdfLabel}}">{{$pdfLabel}}</a>

                    @elseif (isset($item['student_report_version']) && $item['student_report_version'] == 'V-0003')
                        <a class="btn btn-default" target="_blank" href="{{url("/cabinet/pdf---student-progress-v2/pdf?v=3&ei={$item['exam_entity_id']}&ci={$item['class_entity_id']}")}}" title="{{$pdfLabel}}">{{$pdfLabel}}</a>

                    @elseif (isset($item['student_report_version']) && $item['student_report_version'] == 'V-0004')
                        <a class="btn btn-default" target="_blank" href="{{url("/cabinet/pdf---student-progress-v2/pdf?v=4&ei={$item['exam_entity_id']}&ci={$item['class_entity_id']}")}}" title="{{$pdfLabel}}">{{$pdfLabel}}</a>

                    @elseif (isset($item['student_report_version']) && $item['student_report_version'] == 'V-0005')
                        <a class="btn btn-default" target="_blank" href="{{url("/cabinet/pdf---student-progress-v2/pdf?v=5&ei={$item['exam_entity_id']}&ci={$item['class_entity_id']}")}}" title="{{$pdfLabel}}">{{$pdfLabel}}</a>

                    @elseif (isset($item['student_report_version']) && $item['student_report_version'] == 'F-0001')
                        <a class="btn btn-default" target="_blank" href="{{url("/cabinet/pdf---student-progress-v2/pdf?v=6&ei={$item['exam_entity_id']}&ci={$item['class_entity_id']}")}}" title="{{$pdfLabel}}">{{$pdfLabel}}</a>

                    @else
                        <a class="btn btn-default" target="_blank" href="{{url("/cabinet/pdf---student-progress-v1/pdf?ei={$item['exam_entity_id']}&ci={$item['class_entity_id']}")}}" title="{{$pdfLabel}}">{{$pdfLabel}}</a>
                    @endif
                @endif
            </td>
            <td>
                @if ($generated)
                    <a class="btn btn-default" href="{{url("/cabinet/generate-progress/re-generate?eid={$item['exam_entity_id']}&cid={$item['class_entity_id']}")}}" title="Re - generate">Re - generate</a>
                @else
                    <a class="btn btn-default" href="{{url("/cabinet/generate-progress/generate?eid={$item['exam_entity_id']}&cid={$item['class_entity_id']}")}}" title="Generate">Generate</a>
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
            window.location.href = "/cabinet/generate-progress";
        } else {
            window.location.href = "/cabinet/generate-progress?eid=" + this.value;
        }
    });

</script>
@endsection
