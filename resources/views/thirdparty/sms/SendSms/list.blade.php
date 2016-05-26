@extends('layout.cabinet')

@section('title', 'Send SMS')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Send SMS</h3>
        </div>
        <div class="panel-body">

        @include('commons.errors')

        <form class="form-horizontal" action="" method="POST">
            <div class="form-group">
                <label class="col-md-1 control-label" for="sms_type_id">SMS Type</label>
                <div class="col-md-2">
                    <select id="sms_type_id" class="form-control" name="sms_type_id">
                        <option value="none">Select a sms type</option>
                        @foreach($sms->smsTypes() as $option)
                            <option {{ activeSelect($option['sms_type_id'], 'sti') }} value="{{ $option['sms_type_id'] }}">{{ $option['sms_type'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 col-md-offset-6">
                    <h4 class="text-right">SMS Balance:</h4>
                </div>
                <div class="col-md-1">
                    <h4 class="text-left"><strong>{{nr('10000')}}</strong></h4>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-1 control-label" for="sms_account_entity_id">Filter Accounts</label>
                <div class="col-md-2">
                    <select id="sms_account_entity_id" class="form-control" name="sms_account_entity_id">
                        <option value="none">Select an account</option>
                        @foreach($sms->smsAccountTypes() as $option)
                            <option {{ activeSelect($option['entity_id'], 'aei') }} value="{{ $option['entity_id'] }}">{{ $option['drop_down_list_name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 col-md-offset-6">
                    <h4 class="text-right">Current Selected:</h4>
                </div>
                <div class="col-md-1">
                    <h4 class="text-left"><strong>1</strong></h4>
                </div>
            </div>

            <div id="exam-container" style="display:none;" class="form-group">
                <label class="col-md-1 control-label" for="exam_entity_id">Exam Name</label>
                <div class="col-md-2">
                    <select id="exam_entity_id" class="form-control" name="exam_entity_id">
                        <option value="none">Select an exam</option>
                        @foreach($sms->exam() as $option)
                            <option {{ activeSelect($option['exam_entity_id'], 'eei') }} value="{{ $option['exam_entity_id'] }}">{{ $option['exam'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </form>

        <table class="table table-striped table-bordered table-hover" data-datatable>
            <thead>
                <tr>
                    <th class="text-center"><input type="checkbox" id="toggle-subjects" name="toggle-checkbox" value=""></th>
                    <th>Account <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    <th>Mobile</th>
                    <th>SMS Text</th>
                </tr>
            </thead>
            <tbody>
                @foreach([] as $item)
                <tr>
                    <td>{{$item['product']}}</td>
                    <td>{{$item['product_type']}}</td>
                    <td>
                        @if ($item['active'])
                            <strong>Active</strong>
                        @else
                            Inactive
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

    $('#sms_type_id').change(function() {
        if (examResultsIsSelected()) {
            updateQueryString();
        } else {
            updateQueryString(true);
        }
    });

    $('#sms_account_entity_id').change(function() {
        updateQueryString();
    });

    $('#exam_entity_id').change(function() {
        updateQueryString();
    });

    function updateQueryString(skipExamId) {
        window.location.href = "/cabinet/send-sms" + getQueryString(skipExamId);
    }

    // get teh query string depending on which selectboxes are set
    function getQueryString(skipExamId) {
        var sti = $('#sms_type_id option:selected').val();
        var aei = $('#sms_account_entity_id option:selected').val();
        var eei = $('#exam_entity_id option:selected').val();

        var items = [];
        if (sti != "none") {
            items.push('sti='+sti);
        }
        if (aei != "none") {
            items.push('aei='+aei);
        }
        if (!skipExamId && eei != "none") {
            items.push('eei='+eei);
        }
        var queryString = items.join('&');
        if (queryString.length > 1) {
            return '?' + queryString;
        }
        return '';
    }

    function examResultsIsSelected() {
        var text = $('#sms_type_id option:selected').text();
        text = text.trim();
        text = text.toLowerCase();
        return (text.indexOf("exam result") > -1);
    }

    // enable exam dropdown only if sms type is 'Exam Result'
    $(document).ready(function() {
        if (examResultsIsSelected()) {
            $('#exam-container').show();
        }
    });

    // // When selecting a class, uncheck all checkboxes, then display students only from one class
    // $('#sms_type_id').change(function() {
    //     $('.student-entity-id').prop('checked', false);
    //     $('#toggle-subjects').prop('checked', false);
    //     $('.student-entity-id').parents('tr.student-tr').hide();
    //     var classId = this.value;
    //     if (classId != "none") {
    //         $('.student-entity-id').each(function() {
    //             if ($(this).attr('data-classid') == classId) {
    //                 $(this).parents('tr.student-tr').show();
    //             }
    //         });
    //     }
    // });

    // // Checkbox table header - for this page, toggle all checkboxes
    // $('#toggle-subjects').change(function() {
    //     if($(this).is(":checked")) {
    //         var classId = $('#sms_type_id').val();
    //         $('.student-entity-id').each(function() {
    //             if ($(this).attr('data-classid') == classId) {
    //                 $(this).prop('checked', true);
    //             }
    //         });
    //     } else {
    //         $('.student-entity-id').prop('checked', false);
    //     }
    // });

    // // Cancel Button - deselect all checkboxes
    // $('#uncheck-all-checkboxes').on('click', function() {
    //     $('.student-entity-id').prop('checked', false);
    //     $('#toggle-subjects').prop('checked', false);
    //     $('#move-students-submit').prop('disabled', true);
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
    //     var studentIds = $('.student-entity-id:checked').filter(function() {
    //         if ($(this).parents('tr.student-tr').is(":hidden")) {
    //             return false;
    //         }
    //         return true;
    //     }).map(function() {
    //         return this.value;
    //     }).get();

    //     if (studentIds.length == 0) {
    //         alert("No students are selected.");
    //         return false;
    //     }

    //     $('#class_student_ids').val(studentIds.join(','));

    //     return true;
    // });
</script>
@endsection
