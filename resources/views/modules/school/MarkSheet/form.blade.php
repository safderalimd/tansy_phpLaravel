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

                    <div class="form-group">
                        <label class="col-md-4 control-label">Exam - <strong>{{$allItems[0]['exam_name']}}</strong></label>
                        <label class="col-md-4 control-label">Subject - <strong>{{$allItems[0]['subject_name']}}</strong></label>
                        <label class="col-md-4 control-label">Class - <strong>{{$allItems[0]['class_name']}}</strong></label>
                    </div>
                    <br/>
                    <hr/>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Max Marks - <strong>{{$allItems[0]['max_marks']}}</strong></label>
                    </div>

                    <br/>
                    <hr/>

                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Roll Number</th>
                                <th>Student Name</th>
                                <th>Marks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allItems as $item)
                                <tr>
                                    <td>{{$item['student_roll_number']}}</td>
                                    <td>{{$item['student_full_name']}}</td>
                                    <td style="max-width:250px;width:250px;">
                                        <input data-studentId="{{$item['class_student_id']}}" class="input-mark-value form-control" type="text" name="product_name" value="{{$item['student_marks']}}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <hr/>
                    <div class="row">
                        <div class="col-md-7 text-left col-md-offset-5">

                        <form class="form-horizontal" id="save-marks-form" action="{{url("/cabinet/mark-sheet/save")}}" method="POST">
                            {{ csrf_field() }}

                            <input type="hidden" name="markids_marks" id="markids_marks" value="">

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
        var marksIds = $('.input-mark-value').map(function() {
            return $(this).attr('data-studentId') + '-' + this.value;
        }).get();

        if (marksIds.length == 0) {
            alert("There are no marks.");
            return false;
        }

        $('#markids_marks').val(marksIds.join(','));

        return true;
    });
</script>
@endsection
