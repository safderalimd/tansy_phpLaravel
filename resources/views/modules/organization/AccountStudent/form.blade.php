@extends('layout.cabinet')

@section('title', 'Student Account')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th"></i>
                    <h3>Student Account{!! form_label() !!}</h3>
                </div>

                <div class="panel-body edit_form_wrapper">
                    <section class="form_panel">

                    @include('commons.errors')

                    <form id="account-student-form" class="form-horizontal" accept-charset="UTF-8" action="{{ form_action() }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}

<hr/>
<div class="row"><div class="col-md-3 pull-left"><h3>Header</h3></div></div>

                        @include('commons.select', [
                            'label'    => 'Facility' ,
                            'name'     => 'facility_entity_id',
                            'options'  => $account->facilities(),
                            'keyId'    => 'facility_entity_id',
                            'keyName'  => 'facility_name',
                            'none'     => 'Select a facility..',
                            'required' => true,
                        ])

                        @if (file_exists(storage_path("uploads/".domain()."/student-images/{$account->student_entity_id}")))
                            <div class="form-group">
                                <label class="col-md-4 control-label">Image</label>
                                <div class="col-md-8">
                                    <img src="/cabinet/img/student/{{$account->student_entity_id}}?w=300&h=300&ri=<?php echo time().uniqid(); ?>" alt="Student Image" class="img-thumbnail">
                                </div>
                            </div>
                        @endif

                        @if (!$account->isNewRecord())
                            <div class="form-group">
                                <label class="col-md-4 control-label">Upload Image</label>
                                <div class="col-md-8">
                                    <label class="btn btn-default btn-file" style="padding-left:12px;">Choose File...{!! Form::file('attachment', array('class'=>'form-control')) !!}</label>
                                    <span class="file-name"></span>
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <div class="checkbox">
                                    <label><input {{ c('active') }} name="active" type="checkbox"> Active</label>
                                </div>
                            </div>
                        </div>

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
                            <label class="col-md-4 control-label" for="student_last_name">Last Name</label>
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
                            'name'     => 'city_id',
                            'options'  => $account->cities(),
                            'keyId'    => 'city_id',
                            'keyName'  => 'city_name',
                            'none'     => 'Select a city..',
                            'required' => true,
                        ])

                        @include('commons.select', [
                            'label'    => 'City Area',
                            'name'     => 'city_area',
                            'options'  => $account->cityAreas(),
                            'keyId'    => 'city_area',
                            'keyName'  => 'city_area',
                            'none'     => 'Select a city area..',
                        ])

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="postal_code">Postal Code</label>
                            <div class="col-md-8">
                                <input id="postal_code" class="form-control" type="text" name="postal_code" value="{{ v('postal_code') }}" placeholder="Postal Code">
                            </div>
                        </div>

<hr/>
<div class="row"><div class="col-md-3 pull-left"><h3>Student Info</h3></div></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="admission_number">Admission #</label>
                            <div class="col-md-8">
                                <input id="admission_number" class="form-control" type="text" name="admission_number" value="{{ v('admission_number') }}" placeholder="Admission #">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="admission_date">Admission Date</label>
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

                        @include('commons.select', [
                            'label'    => 'Admitted To' ,
                            'name'     => 'admitted_class_entity_id',
                            'options'  => $account->classes(),
                            'keyId'    => 'class_entity_id',
                            'keyName'  => 'class_name',
                            'none'     => 'Select a class group..',
                            'required' => true,
                        ])

                        <div class="form-group">
                            <label class="col-md-4 control-label"">Current Class</label>
                            <div class="col-md-8">
                                <label class="col-md-4 control-label">
                                <?php $currentClass = '-'; ?>
                                @foreach($account->classGroups() as $option)
                                    @if ($option['class_group_entity_id'] == $account->class_student_id)
                                        <?php $currentClass = $option['class_group']; ?>
                                    @endif
                                @endforeach
                                {{$currentClass}}
                                </label>
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
                            'name'     => 'caste_id',
                            'options'  => $account->castes(),
                            'keyId'    => 'caste_id',
                            'keyName'  => 'caste_name',
                            'none'     => 'Select a caste..',
                        ])

                        @include('commons.select', [
                            'label'    => 'Religion',
                            'name'     => 'religion_id',
                            'options'  => $account->religions(),
                            'keyId'    => 'religion_id',
                            'keyName'  => 'religion_name',
                            'none'     => 'Select a religion..',
                        ])

                        @include('commons.select', [
                            'label'    => 'Language',
                            'name'     => 'mother_language_id',
                            'options'  => $account->languages(),
                            'keyId'    => 'language_id',
                            'keyName'  => 'language_name',
                            'none'     => 'Select a language..',
                        ])

<hr/>
<div class="row"><div class="col-md-3 pull-left"><h3>Parent</h3></div></div>

                    <?php
                        $parentCount = count($account->relationshipRows());
                    ?>
                    @for ($i=1; $i<=3; $i++)
                        <div class="parent-set" @if($i!=1 && $i>$parentCount) style="display:none;" @endif>

                            <?php
                                $relationshipLabel = 'Relationship Type ' . $i;
                                $relationshipName = 'relationship_type_id_' . $i;

                                $parentLabel = 'Name ' . $i;
                                $parentName = 'parent_name_' . $i;

                                $designationLabel = 'Designation ' . $i;
                                $designationName = 'designation_id_' . $i;

                                $qualificationLabel = 'Qualification ' . $i;
                                $qualificationName = 'qualification_id_' . $i;
                            ?>

                            @include('commons.select', [
                                'label'    => $relationshipLabel,
                                'name'     => $relationshipName,
                                'options'  => $account->relationships(),
                                'keyId'    => 'relationship_type_id',
                                'keyName'  => 'relationship_name',
                                'none'     => 'Select a relationship type..',
                            ])

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="{{$parentName}}">{{$parentLabel}}</label>
                                <div class="col-md-8">
                                    <input id="{{$parentName}}" class="form-control" type="text" name="{{$parentName}}" value="{{ v($parentName) }}" placeholder="{{$parentLabel}}">
                                </div>
                            </div>

                            @include('commons.select', [
                                'label'    => $designationLabel,
                                'name'     => $designationName,
                                'options'  => $account->designations(),
                                'keyId'    => 'designation_id',
                                'keyName'  => 'designation_name',
                                'none'     => 'Select a designation..',
                            ])

                            @include('commons.select', [
                                'label'    => $qualificationLabel,
                                'name'     => $qualificationName,
                                'options'  => $account->qualifications(),
                                'keyId'    => 'qualification_id',
                                'keyName'  => 'qualification_name',
                                'none'     => 'Select a qualification..',
                            ])

                            @if($i!=3) <hr/> @endif

                        </div>


                    @endfor

                    @if ($parentCount < 3)
                        <div class="row">
                            <div class="col-md-8 col-md-offset-4">
                                <button class="add-parent-btn btn btn-default" type="button">Add Parent</button>
                            </div>
                        </div>
                    @endif

                    <input type="hidden" id="parent_info_list" name="parent_info_list" value="">

<hr/>
<div class="row"><div class="col-md-3 pull-left"><h3>ID Card</h3></div></div>

                    <?php
                        $documentCount = count($account->documentRows());
                    ?>
                    @for ($i=1; $i<=5; $i++)
                        <div class="document-set" @if($i!=1 && $i>$documentCount) style="display:none;" @endif>

                            <?php
                                $documentTypeLabel = 'Document Type ' . $i;
                                $documentTypeName = 'document_type_id_' . $i;

                                $documentLabel = 'Document Number ' . $i;
                                $documentNumber = 'document_number_' . $i;
                            ?>

                            @include('commons.select', [
                                'label'    => $documentTypeLabel,
                                'name'     => $documentTypeName,
                                'options'  => $account->documentType(),
                                'keyId'    => 'document_type_id',
                                'keyName'  => 'document_type',
                                'none'     => 'Select a document type..',
                            ])

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="{{$documentNumber}}">{{$documentLabel}}</label>
                                <div class="col-md-8">
                                    <input id="{{$documentNumber}}" class="form-control" type="text" name="{{$documentNumber}}" value="{{ v($documentNumber) }}" placeholder="{{$documentLabel}}">
                                </div>
                            </div>

                            @if($i!=5) <hr/> @endif

                        </div>

                    @endfor

                    @if ($documentCount < 5)
                        <div class="row">
                            <div class="col-md-8 col-md-offset-4">
                                <button class="add-document-btn btn btn-default" type="button">Add Document</button>
                            </div>
                        </div>
                    @endif

                    <input type="hidden" id="document_info_list" name="document_info_list" value="">


<hr/>
<div class="row"><div class="col-md-3 pull-left"><h3>Login</h3></div></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="login_name">Login Name</label>
                            <div class="col-md-8">
                                <input disabled="disabled" id="login_name" class="form-control" type="text" name="login_name" value="{{ v('mobile_phone') }}" placeholder="Login Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="password">Password</label>
                            <div class="col-md-8">
                                <input id="password" class="form-control" type="password" name="password" value="{{ v('password') }}" placeholder="Password">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <div class="checkbox">
                                    <label>
                                        <input {{ c('login_active') }} name="login_active" type="checkbox"> Login Active
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="security_group_entity_id">Security Group</label>
                            <div class="col-md-8">
                                <select disabled="disabled" id="security_group_entity_id" class="form-control" name="security_group_entity_id">
                                    @foreach($account->securityGroupForParent() as $option)
                                        <option value="{{ $option['security_group_entity_id'] }}">{{ $option['security_group'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @include('commons.select', [
                            'label'    => 'Default Facility',
                            'name'     => 'view_default_facility_id',
                            'options'  => $account->facilitiesForOwner(),
                            'keyId'    => 'facility_entity_id',
                            'keyName'  => 'facility_name',
                            'none'     => 'Select a facility..',
                        ])

                        <hr/>

                        @include('modules.custom-fields.fields', [
                            'fields' => $account->customFields(),
                            'model'  => $account,
                        ])
                        @yield('custom-fields')

                        <div class="row_footer">
                           <div class="col-md-12 text-center grid_footer">
                                <button class="btn btn-primary grid_btn" type="submit">Save</button>
                                <a href="{{ url("/cabinet/student-account")}}" class="btn btn-default cancle_btn">Cancel</a>
                            </div>
                        </div>
                        <br/><br/>

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

    $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    $(document).ready( function() {

        $("#mobile_phone").keyup(function() {
            $('#login_name').val($(this).val());
        });

        $("#mobile_phone").keypress(function() {
            $('#login_name').val($(this).val());
        });

        $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
            $('.file-name').text(label);
        });

        $('.add-parent-btn').on('click', function() {
            var count = 0;
            $('.parent-set').each(function() {
                count++;
                if ($(this).is(':hidden')) {

                    $(this).show();
                    return false;
                };
            });
            if (count == 3) {
                $(this).prop('disabled', true);
            }
        });

        $('.add-document-btn').on('click', function() {
            var count = 0;
            $('.document-set').each(function() {
                count++;
                if ($(this).is(':hidden')) {

                    $(this).show();
                    return false;
                };
            });
            if (count == 5) {
                $(this).prop('disabled', true);
            }
        });
    });

    // When submitting the form, prepend all selected checkboxes
    $('#account-student-form').submit(function() {
        if (! $('#account-student-form').valid()) {
            return false;
        }

        append_custom_fields();

        var parent_info_list = [];
        for (var i = 1; i<=3; i++) {
            var relationshipName = '#relationship_type_id_' + i;
            var parentName = '#parent_name_' + i;
            var designationName = '#designation_id_' + i;
            var qualificationName = '#qualification_id_' + i;
            if (! $(relationshipName).closest('.parent-set').is(':hidden')) {

                var relationship = $(relationshipName + ' option:selected').val();
                var parent = $(parentName).val();
                if (typeof parent == 'string') {
                    parent = parent.trim();
                    parent = parent.replace(/\|/g, '');
                    parent = parent.replace(/\$<>\$/g, '');
                }

                var designation = $(designationName + ' option:selected').val();
                var qualification = $(qualificationName + ' option:selected').val();

                if (relationship == 'none') {
                    relationship = 'null';
                }
                if (designation == 'none') {
                    designation = 'null';
                }
                if (qualification == 'none') {
                    qualification = 'null';
                }

                var row = relationship + '$<>$' + parent + '$<>$' + designation + '$<>$' + qualification;
                parent_info_list.push(row);
            }
        };

        $('#parent_info_list').val(parent_info_list.join('|'));


        var document_info_list = [];
        for (var i = 1; i<=3; i++) {
            var documentTypeName = '#document_type_id_' + i;
            var documentNumber = '#document_number_' + i;

            if (! $(documentTypeName).closest('.document-set').is(':hidden')) {

                var documentType = $(documentTypeName + ' option:selected').val();
                if (documentType == 'none') {
                    documentType = 'null';
                }
                var documentNr = $(documentNumber).val();
                if (typeof documentNr == 'string') {
                    documentNr = documentNr.trim();
                    documentNr = documentNr.replace(/\|/g, '');
                    documentNr = documentNr.replace(/\$<>\$/g, '');
                }

                var row = documentType + '$<>$' + documentNr;
                document_info_list.push(row);
            }
        };

        $('#document_info_list').val(document_info_list.join('|'));

        return true;
    });

    $('#account-student-form').validate({
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
                phoneNumber: true,
                maxlength: 100
            },
            mobile_phone: {
                phoneNumber: true,
                maxlength: 100
            },
            address1: {
                required: true,
                maxlength: 128
            },
            address2: {
                maxlength: 128
            },
            city_id: {
                requiredSelect: true
            },
            postal_code: {
                maxlength: 30
            },
            admission_number: {
                required: true,
                maxlength: 128
            },
            admission_date: {
                required: true,
                dateISO: true
            },
            admitted_class_entity_id: {
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
            password: {
                minlength:8
            }
            @yield('validation-rules')
        }
    });

    $('#student_date_of_birth').change(function() {
        $('#student_date_of_birth').valid();
    });
    $('#admission_date').change(function() {
        $('#admission_date').valid();
    });

</script>
@endsection
