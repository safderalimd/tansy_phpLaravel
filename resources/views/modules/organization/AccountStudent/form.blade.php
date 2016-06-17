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

                    <form class="form-horizontal" accept-charset="UTF-8" action="{{ form_action() }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}

<hr/>
<div class="row"><div class="col-md-3 pull-left"><h3>Header</h3></div></div>

                        @include('commons.select', [
                            'label'   => 'Facility' ,
                            'name'    => 'facility_entity_id',
                            'options' => $account->facilities(),
                            'keyId'   => 'facility_entity_id',
                            'keyName' => 'facility_name',
                            'none'    => 'Select a facility..',
                        ])

                        @if (file_exists(storage_path('uploads/student-images/'. domain() . "/{$account->student_entity_id}")))
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
                            <label class="col-md-4 control-label" for="student_first_name">First Name</label>
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
                            <label class="col-md-4 control-label" for="student_date_of_birth">Date of Birth</label>
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
                            <label class="col-md-4 control-label" for="student_gender">Gender</label>
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
                            <label class="col-md-4 control-label" for="address1">Adress 1</label>
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
                            'label'   => 'City',
                            'name'    => 'city_id',
                            'options' => $account->cities(),
                            'keyId'   => 'city_id',
                            'keyName' => 'city_name',
                            'none'    => 'Select a city..',
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

                        @include('commons.select', [
                            'label'   => 'Admitted To' ,
                            'name'    => 'admitted_class_entity_id',
                            'options' => $account->classes(),
                            'keyId'   => 'class_entity_id',
                            'keyName' => 'class_name',
                            'none'    => 'Select a class group',
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
                            <label class="col-md-4 control-label" for="identification1">Identification 1</label>
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

                        @include('commons.select', [
                            'label'   => 'Relationship',
                            'name'    => 'parent_relationship_type_id',
                            'options' => $account->relationships(),
                            'keyId'   => 'relationship_type_id',
                            'keyName' => 'relationship_name',
                            'none'    => 'Select a relationship type..',
                        ])

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="parent_gender">Gender</label>
                            <div class="col-md-8">
                                <label class="radio-inline">
                                    <input type="radio" name="parent_gender" {{ r('parent_gender', 'M') }} id="parent_gender1" value="M">
                                    Male
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="parent_gender" {{ r('parent_gender', 'F') }} id="parent_gender2" value="F">
                                    Female
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="parent_first_name">First Name</label>
                            <div class="col-md-8">
                                <input id="parent_first_name" class="form-control" type="text" name="parent_first_name" value="{{ v('parent_first_name') }}" placeholder="First Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="parent_middle_name">Middle Name</label>
                            <div class="col-md-8">
                                <input id="parent_middle_name" class="form-control" type="text" name="parent_middle_name" value="{{ v('parent_middle_name') }}" placeholder="Middle Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="parent_last_name">Last Name</label>
                            <div class="col-md-8">
                                <input id="parent_last_name" class="form-control" type="text" name="parent_last_name" value="{{ v('parent_last_name') }}" placeholder="Last Name">
                            </div>
                        </div>

                        @include('commons.select', [
                            'label'    => 'Designation',
                            'name'     => 'parent_designation_id',
                            'options'  => $account->designations(),
                            'keyId'    => 'designation_id',
                            'keyName'  => 'designation_name',
                            'none'     => 'Select a designation..',
                        ])

<hr/>
<div class="row"><div class="col-md-3 pull-left"><h3>Identification</h3></div></div>

                        @include('commons.select', [
                            'label'    => 'Document Type',
                            'name'     => 'document_type_id',
                            'options'  => $account->documentType(),
                            'keyId'    => 'document_type_id',
                            'keyName'  => 'document_type',
                            'none'     => 'Select a document type..',
                        ])

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="document_number">Document Number</label>
                            <div class="col-md-8">
                                <input id="document_number" class="form-control" type="text" name="document_number" value="{{ v('document_number') }}" placeholder="Document Number">
                            </div>
                        </div>

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
    });

</script>
@endsection
