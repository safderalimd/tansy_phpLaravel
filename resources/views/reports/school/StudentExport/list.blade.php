@extends('layout.cabinet')

@section('title', 'Student Export')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Student Export</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" id="generate-report-form" action="/cabinet/student-export/pdf" target="_blank" method="GET">
                <input type="hidden" id="row_type" name="rt" value="">
                <input type="hidden" id="random_id" name="ri" value="">

                <div class="form-group">
                    <div class="col-md-3 col-md-offset-1">
                        <select id="primary_key_id" class="form-control" name="pk">
                            <option value="none">Select an option..</option>
                            @foreach($export->dropdown() as $option)
                                <option data-rowType="{{ $option['row_type'] }}" value="{{ $option['primary_key_id'] }}">{{ $option['drop_down_list_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="checkbox col-md-offset-1">
                    <label><input type="checkbox" id="toggle-subjects" name="toggle_checkbox" value=""> Check All</label>
                </div>

                <br/>

                <div class="checkbox col-md-offset-1">
                    <label><input type="checkbox" class="pdf-column" value="1" name="first_name">First Name</label>
                </div>
                <div class="checkbox col-md-offset-1">
                    <label><input type="checkbox" class="pdf-column" value="1" name="last_name">Last Name</label>
                </div>
                <div class="checkbox col-md-offset-1">
                    <label><input type="checkbox" class="pdf-column" value="1" name="date_of_birth">Date of Birth</label>
                </div>
                <div class="checkbox col-md-offset-1">
                    <label><input type="checkbox" class="pdf-column" value="1" name="gender">Gender</label>
                </div>
                <div class="checkbox col-md-offset-1">
                    <label><input type="checkbox" class="pdf-column" value="1" name="class_name">Class Name</label>
                </div>
                <div class="checkbox col-md-offset-1">
                    <label><input type="checkbox" class="pdf-column" value="1" name="roll_number">Roll Number</label>
                </div>
                <div class="checkbox col-md-offset-1">
                    <label><input type="checkbox" class="pdf-column" value="1" name="admission_number">Admission NUmber</label>
                </div>
                <div class="checkbox col-md-offset-1">
                    <label><input type="checkbox" class="pdf-column" value="1" name="admission_date">Admission Date</label>
                </div>
                <div class="checkbox col-md-offset-1">
                    <label><input type="checkbox" class="pdf-column" value="1" name="identification1">Identification1</label>
                </div>
                <div class="checkbox col-md-offset-1">
                    <label><input type="checkbox" class="pdf-column" value="1" name="parent_full_name">Parent Full Name</label>
                </div>
                <div class="checkbox col-md-offset-1">
                    <label><input type="checkbox" class="pdf-column" value="1" name="parent_designation">Parent Designation</label>
                </div>
                <div class="checkbox col-md-offset-1">
                    <label><input type="checkbox" class="pdf-column" value="1" name="caste">Caste</label>
                </div>
                <div class="checkbox col-md-offset-1">
                    <label><input type="checkbox" class="pdf-column" value="1" name="religion">Religion</label>
                </div>
                <div class="checkbox col-md-offset-1">
                    <label><input type="checkbox" class="pdf-column" value="1" name="mother_toungue">Mother Toungue</label>
                </div>
                <div class="checkbox col-md-offset-1">
                    <label><input type="checkbox" class="pdf-column" value="1" name="mobile">Mobile</label>
                </div>
                <div class="checkbox col-md-offset-1">
                    <label><input type="checkbox" class="pdf-column" value="1" name="address1">Address1</label>
                </div>
                <div class="checkbox col-md-offset-1">
                    <label><input type="checkbox" class="pdf-column" value="1" name="address2">Address2</label>
                </div>
                <div class="checkbox col-md-offset-1">
                    <label><input type="checkbox" class="pdf-column" value="1" name="city">City</label>
                </div>
                <div class="checkbox col-md-offset-1">
                    <label><input type="checkbox" class="pdf-column" value="1" name="postal_code">Postal Code</label>
                </div>
                <div class="checkbox col-md-offset-1">
                    <label><input type="checkbox" class="pdf-column" value="1" name="document_number">Document Number</label>
                </div>

                <br/>

                <div class="row">
                    <div class="col-md-3 col-md-offset-1">
                        <button id="generate-report" class="btn btn-primary" type="submit">Generate Report</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">

    $('#generate-report-form').submit(function() {
        if (! $('#generate-report-form').valid()) {
            return false;
        }

        if ($('#primary_key_id option:selected').val() == 'none') {
            alert('Please select an option.');
            return false;
        }

        if ($('.pdf-column:checked').length == 0) {
            alert('No checkboxes are selected.');
            return false;
        }

        var rowType = $('#primary_key_id option:selected').attr('data-rowType');
        var primaryKeyId = $('#primary_key_id option:selected').val();
        if (primaryKeyId == '') {
            var primaryKeyId = $('#primary_key_id option:selected').val(0);
        }
        $('#row_type').val(rowType);
        $('#random_id').val(Date.now());
        return true;
    });

    // check/uncheck all checkboxes
    $('#toggle-subjects').change(function() {
        $('.pdf-column').prop('checked', false);
        if($(this).is(":checked")) {
            $('.pdf-column').prop('checked', true)
        }
        $('#generate-report-form').valid();
    });

    $('.pdf-column').change(function() {
        $('#generate-report-form').valid();
    });

    $('#generate-report-form').validate({
        rules: {
            pk: {
                requiredSelect: true
            },
            toggle_checkbox: {
                required: function(elem) {
                    return $("input.pdf-column:checked").length == 0;
                }
            }
        },
        messages: {
            toggle_checkbox: {
                required: "Please select at least 1 checkbox."
            }
        }
    });

</script>
@endsection
