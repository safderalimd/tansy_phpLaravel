@extends('layout.cabinet')

@section('title', 'Mark Sheet Detail')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th"></i>
                    <h3>Mark Sheet Detail</h3>
                </div>

                <div class="panel-body edit_form_wrapper">
                    <section class="form_panel">

                    @include('commons.errors')

                    <?php $allItems = $markSheet->getMarkSheetDetail(); ?>

                    @if (count($allItems))
                        <?php
                            $examEntityId = $allItems[0]['exam_entity_id'];
                            $classEntityId = $allItems[0]['class_entity_id'];
                            $subjectEntityId = $allItems[0]['subject_entity_id'];
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="pull-left"><strong>{{$allItems[0]['exam_name']}}</strong></h3>
                            </div>
                        </div>
                        <hr style="margin:0px; padding:0px;" />
                        <div class="row">
                            <div class="col-md-6"><h4 class="pull-left">Class - {{$allItems[0]['class_name']}}</h4></div>
                            <div class="col-md-6"><h4 class="pull-right">Subject - {{$allItems[0]['subject_name']}}</h4></div>
                        </div>
                        <hr style="margin:0px; padding:0px;" />
                        <div class="row" style="">
                            <div class="col-md-12">
                                <h4 class="pull-right">Max Marks - {{$allItems[0]['max_marks']}}</h4>
                            </div>
                        </div>
                    @else
                        There is not data for this form.
                    @endif
                    <hr style="margin-top:0px;" />

                    <form id="marks-table" class="form-horizontal" method="POST">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Roll Number</th>
                                <th>Student Name</th>
                                <th>Marks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach($allItems as $item)
                                <tr>
                                    <td>{{$item['student_roll_number']}}</td>
                                    <td>{{$item['student_full_name']}}</td>
                                    <td style="max-width:150px;width:150px;">
                                        <input data-rule-required="true" data-rule-number="true" data-rule-min="0" data-studentId="{{$item['class_student_id']}}" class="input-mark-value form-control" type="text" name="product_name_{{$i++}}" value="{{marks($item['student_marks'])}}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </form>

                    <hr/>
                    <div class="row">
                        <div class="col-md-7 text-left col-md-offset-5">

                        <form class="form-horizontal" id="save-marks-form" action="{{url("/cabinet/mark-sheet/save")}}" method="POST">
                            {{ csrf_field() }}

                            <input type="hidden" name="clsStudIDs_marks" id="clsStudIDs_marks" value="">

                            <input type="hidden" name="exam_entity_id" id="id-exam_entity_id" value="{{$examEntityId}}">
                            <input type="hidden" name="class_entity_id" id="id-class_entity_id" value="{{$classEntityId}}">
                            <input type="hidden" name="subject_entity_id" id="id-subject_entity_id" value="{{$subjectEntityId}}">

                            <button class="btn btn-primary grid_btn" type="submit" id="save-marks-submit">Save</button>
                        </form>

                        </div>
                    </div>
                    <br/>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
<script type="text/javascript">

    // When submitting the form, prepend all selected checkboxes
    $('#save-marks-form').submit(function() {
        if (! $('#marks-table').valid()) {
            return false;
        }

        var marksIds = $('.input-mark-value').map(function() {
            return $(this).attr('data-studentId') + '-' + this.value;
        }).get();

        if (marksIds.length == 0) {
            alert("There are no marks.");
            return false;
        }

        $('#clsStudIDs_marks').val(marksIds.join(','));

        return true;
    });

    $('#marks-table').validate();

</script>
@endsection
