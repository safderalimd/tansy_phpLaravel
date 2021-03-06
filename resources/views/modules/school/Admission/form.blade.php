@extends('layout.cabinet')

@section('title', 'Admission')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th"></i>
                    <h3>Admission{!! form_label() !!}</h3>
                </div>

                <div class="panel-body edit_form_wrapper">
                    <section class="form_panel">

                    @include('commons.errors')

                    <form id="admission-form" class="form-horizontal" action="{{ form_action() }}" method="POST">
                        {{ csrf_field() }}

<hr/>
<div class="row"><div class="col-md-3 pull-left"><h3>Header</h3></div></div>

                        @include('commons.select', [
                            'label'    => 'Facility' ,
                            'name'     => 'facility_entity_id',
                            'options'  => $admission->facilitiesForOwner(),
                            'keyId'    => 'facility_entity_id',
                            'keyName'  => 'facility_name',
                            'none'     => 'Select a facility..',
                            'required' => true,
                        ])

                        @if (!$admission->isNewRecord())
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="move_error">Data Error</label>
                                <div class="col-md-8">
                                    <div style="padding: 0px 10px 0px 10px; margin-top:7px;" class="{{ !empty($admission->move_error) ? 'alert-danger'  : '' }}">
                                        @if (!empty($admission->move_error))
                                            {{ $admission->move_error }}
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

<hr/>
<div class="row"><div class="col-md-3 pull-left"><h3>Student</h3></div></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="student_first_name">First Name</label>
                            <div class="col-md-8">
                                <input id="student_first_name" class="form-control" type="text" name="student_first_name" value="{{ v('student_first_name') }}" placeholder="First Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="student_middle_name">Middle Name</label>
                            <div class="col-md-8">
                                <input id="student_middle_name" class="form-control" type="text" name="student_middle_name" value="{{ v('student_middle_name') }}" placeholder="Middle Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="student_last_name">Last Name</label>
                            <div class="col-md-8">
                                <input id="student_last_name" class="form-control" type="text" name="student_last_name" value="{{ v('student_last_name') }}" placeholder="Last Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="student_date_of_birth">Date of Birth</label>
                            <div class="col-md-8">
                                <div class="input-group date">
                                    <input id="student_date_of_birth" class="form-control" type="text" name="student_date_of_birth" value="{{ v('student_date_of_birth') }}" placeholder="Date of Birth">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><span
                                                    class="glyphicon glyphicon-calendar"></span></button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="student_gender">Gender</label>
                            <div class="col-md-8">
                                <label class="radio-inline">
                                    <input type="radio" name="student_gender" {{ r('student_gender', 'M') }} id="gender1" value="M">
                                    Male
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="student_gender" {{ r('student_gender', 'F') }} id="gender2" value="F">
                                    Female
                                </label>
                            </div>
                        </div>

<hr/>
<div class="row"><div class="col-md-3 pull-left"><h3>Contact</h3></div></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="email">Email</label>
                            <div class="col-md-8">
                                <input id="email" class="form-control" type="email" name="email" value="{{ v('email') }}" placeholder="Email">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="home_phone">Home Phone</label>
                            <div class="col-md-8">
                                <input id="home_phone" class="form-control" type="text" name="home_phone" value="{{ v('home_phone') }}" placeholder="Home Phone">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="mobile_phone">Mobile Phone</label>
                            <div class="col-md-8">
                                <input id="mobile_phone" class="form-control" type="text" name="mobile_phone" value="{{ v('mobile_phone') }}" placeholder="Mobile Phone">
                            </div>
                        </div>

<hr/>
<div class="row"><div class="col-md-3 pull-left"><h3>Adress</h3></div></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="address1">Adress 1</label>
                            <div class="col-md-8">
                                <input id="address1" class="form-control" type="text" name="address1" value="{{ v('address1') }}" placeholder="Adress 1">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="address2">Adress 2</label>
                            <div class="col-md-8">
                                <input id="address2" class="form-control" type="text" name="address2" value="{{ v('address2') }}" placeholder="Adress 2">
                            </div>
                        </div>

                        @include('commons.select', [
                            'label'    => 'City',
                            'name'     => 'city_name',
                            'options'  => $admission->cities(),
                            'keyId'    => 'city_name',
                            'keyName'  => 'city_name',
                            'none'     => 'Select a city..',
                            'required' => true,
                        ])

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="city_area">City Area</label>
                            <div class="col-md-8">
                                <select autocomplete="off" id="city_area" class="form-control" name="city_area">
                                    <option></option>
                                    <?php
                                        $cityAreaValue = '';
                                    ?>
                                    @foreach($admission->cityAreas() as $option)
                                        <?php
                                            if (old('city_area') == $option['city_area']) {
                                                $cityAreaValue = $option['city_area'];
                                            }
                                        ?>
                                        <option {{ s('city_area', $option['city_area']) }} value="{{ $option['city_area'] }}">{{ $option['city_area'] }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" value="{{$cityAreaValue}}" name="city_area_new" id="city_area_new">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="postal_code">Postal Code</label>
                            <div class="col-md-8">
                                <input id="postal_code" class="form-control" type="text" name="postal_code" value="{{ v('postal_code') }}" placeholder="Postal Code">
                            </div>
                        </div>

<hr/>
<div class="row"><div class="col-md-3 pull-left"><h3>Student Info</h3></div></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="admission_number">Admission #</label>
                            <div class="col-md-8">
                                <input id="admission_number" class="form-control" type="text" name="admission_number" value="{{ v('admission_number') }}" placeholder="Admission #">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="admission_date">Admission Date</label>
                            <div class="col-md-8">
                                <div class="input-group date">
                                    <input id="admission_date" class="form-control" type="text" name="admission_date" value="{{ v('admission_date') }}" placeholder="Admission Date">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><span
                                                    class="glyphicon glyphicon-calendar"></span></button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="admitted_to_class_group_entity_id">Admitted Class Group</label>
                            <div class="col-md-8">
                                <select id="admitted_to_class_group_entity_id" class="form-control" name="admitted_to_class_group_entity_id">
                                    <option value="none">Select a class group..</option>
                                    @foreach($admission->classGroups() as $option)
                                        <option {{ s('admitted_to_class_group', $option['class_group']) }} value="{{ $option['class_group_entity_id'] }}">{{ $option['class_group'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="student_roll_number">Roll Number</label>
                            <div class="col-md-8">
                                <input id="student_roll_number" class="form-control" type="text" name="student_roll_number" value="{{ v('student_roll_number') }}" placeholder="Roll Number">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="identification1">Identification 1</label>
                            <div class="col-md-8">
                                <input id="identification1" class="form-control" type="text" name="identification1" value="{{ v('identification1') }}" placeholder="Identification 1">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="identification2">Identification 2</label>
                            <div class="col-md-8">
                                <input id="identification2" class="form-control" type="text" name="identification2" value="{{ v('identification2') }}" placeholder="Identification 2">
                            </div>
                        </div>

                        @include('commons.select', [
                            'label'    => 'Caste',
                            'name'     => 'caste_name',
                            'options'  => $admission->castes(),
                            'keyId'    => 'caste_name',
                            'keyName'  => 'caste_name',
                            'none'     => 'Select a caste..',
                        ])

                        @include('commons.select', [
                            'label'    => 'Religion',
                            'name'     => 'religion_name',
                            'options'  => $admission->religions(),
                            'keyId'    => 'religion_name',
                            'keyName'  => 'religion_name',
                            'none'     => 'Select a religion..',
                        ])

                        @include('commons.select', [
                            'label'    => 'Communication Language',
                            'name'     => 'mother_language_name',
                            'options'  => $admission->languages(),
                            'keyId'    => 'language_name',
                            'keyName'  => 'language_name',
                            'none'     => 'Select a communication language..',
                        ])

<hr/>
<div class="row"><div class="col-md-3 pull-left"><h3>Parent</h3></div></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="father_name">Father Name</label>
                            <div class="col-md-8">
                                <input id="father_name" class="form-control" type="text" name="father_name" value="{{ v('father_name') }}" placeholder="Father Name">
                            </div>
                        </div>

                        @include('commons.select', [
                            'label'    => 'Father Qualification',
                            'name'     => 'father_qualification',
                            'options'  => $admission->qualifications(),
                            'keyId'    => 'qualification_name',
                            'keyName'  => 'qualification_name',
                            'none'     => 'Select a qualification..',
                        ])

                        @include('commons.select', [
                            'label'    => 'Father Designation',
                            'name'     => 'father_designation',
                            'options'  => $admission->designations(),
                            'keyId'    => 'designation_name',
                            'keyName'  => 'designation_name',
                            'none'     => 'Select a designation..',
                        ])

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="mother_name">Mother Name</label>
                            <div class="col-md-8">
                                <input id="mother_name" class="form-control" type="text" name="mother_name" value="{{ v('mother_name') }}" placeholder="Mother Name">
                            </div>
                        </div>

                        @include('commons.select', [
                            'label'    => 'Mother Qualification',
                            'name'     => 'mother_qualification',
                            'options'  => $admission->qualifications(),
                            'keyId'    => 'qualification_name',
                            'keyName'  => 'qualification_name',
                            'none'     => 'Select a qualification..',
                        ])

                        @include('commons.select', [
                            'label'    => 'Mother Designation',
                            'name'     => 'mother_designation',
                            'options'  => $admission->designations(),
                            'keyId'    => 'designation_name',
                            'keyName'  => 'designation_name',
                            'none'     => 'Select a designation..',
                        ])

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="guardian_name">Gaurdian Name</label>
                            <div class="col-md-8">
                                <input id="guardian_name" class="form-control" type="text" name="guardian_name" value="{{ v('guardian_name') }}" placeholder="Gaurdian Name">
                            </div>
                        </div>

                        @include('commons.select', [
                            'label'    => 'Gaurdian Qualification',
                            'name'     => 'guardian_qualification',
                            'options'  => $admission->qualifications(),
                            'keyId'    => 'qualification_name',
                            'keyName'  => 'qualification_name',
                            'none'     => 'Select a qualification..',
                        ])

                        @include('commons.select', [
                            'label'    => 'Gaurdian Designation',
                            'name'     => 'guardian_designation',
                            'options'  => $admission->designations(),
                            'keyId'    => 'designation_name',
                            'keyName'  => 'designation_name',
                            'none'     => 'Select a designation..',
                        ])

<hr/>
<div class="row"><div class="col-md-3 pull-left"><h3>ID Card</h3></div></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="aadhar_card_number">Aadhar Card</label>
                            <div class="col-md-8">
                                <input id="aadhar_card_number" class="form-control" type="text" name="aadhar_card_number" value="{{ v('aadhar_card_number') }}" placeholder="Aadhar Card">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="pan_card_number">Pan Card</label>
                            <div class="col-md-8">
                                <input id="pan_card_number" class="form-control" type="text" name="pan_card_number" value="{{ v('pan_card_number') }}" placeholder="Pan Card">
                            </div>
                        </div>

                        <hr/>

                        @include('modules.custom-fields.fields', [
                            'fields' => $admission->customFields(),
                            'model'  => $admission,
                        ])
                        @yield('custom-fields')

                        <div class="row grid_footer">
                           <div class="col-md-8 col-md-offset-4">
                                <button class="btn btn-primary grid_btn" type="submit">Save</button>
                                <a href="{{ url("/cabinet/admission")}}" class="btn btn-default cancle_btn">Cancel</a>
                            </div>
                        </div>

                    </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@yield('custom-fields-scripts')

<script type="text/javascript">

    $(document).ready(function(){
        $('#city_area').combobox({
            bsVersion: '3'
        });
    });

    // When submitting the form, prepend all selected checkboxes
    $('#admission-form').submit(function() {
        if (! $('#admission-form').valid()) {
            return false;
        }

        append_custom_fields();

        return true;
    });

    $('#admission-form').validate({
        rules: {
            facility_entity_id: {
                requiredSelect: true
            },
            student_first_name: {
                required: true,
                maxlength: 30
            },
            student_middle_name: {
                maxlength: 30
            },
            student_last_name: {
                required: true,
                maxlength: 30
            },
            student_date_of_birth: {
                required: true,
                dateISO: true
            },
            student_gender: {
                required: true
            },
            email: {
                email: true,
                maxlength: 100
            },
            home_phone: {
                phoneNumber: true
            },
            mobile_phone: {
                phoneNumber: true
            },
            address1: {
                required: true,
                maxlength: 128
            },
            address2: {
                maxlength: 128
            },
            city_name: {
                requiredSelect: true
            },
            postal_code: {
                maxlength: 30
            },
            admission_number: {
                maxlength: 128
            },
            admission_date: {
                dateISO: true
            },
            admitted_to_class_group_entity_id: {
                requiredSelect: true
            },
            student_roll_number: {
                maxlength: 45
            },
            identification1: {
                required: true,
                maxlength: 100
            },
            identification2: {
                maxlength: 100
            },
            caste_name: {

            },
            religion_name: {

            },
            mother_language_name: {

            }
            @yield('validation-rules')
        }
    });

    $('#student_date_of_birth, #admission_date').change(function() {
        $('#student_date_of_birth').valid();
        $('#admission_date').valid();
    });

</script>
@endsection
