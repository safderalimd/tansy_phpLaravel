@extends('layout.cabinet')

@section('title', 'New Admission')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th"></i>
                    <h3>Admission</h3>
                    @if(Request::segment(3) == "edit")
                        <label>- Update</label>
                    @else
                        <label>- Add New Record</label>
                    @endif
                </div>

                <div class="panel-body edit_form_wrapper">
                    <section class="form_panel">

                    @include('commons.errors')

                    <form class="form-horizontal" action="{{ url("/cabinet/admission/create")}}" method="POST">
                        {{ csrf_field() }}


                        <hr/>
                        <div class="row"><div class="col-md-3 pull-left"><h3>Header</h3></div></div>

                        @include('modules.school.Admission.select', [
                            'label'   => 'Facility' ,
                            'options' => $admission->facilities(),
                            'keyId'   => 'facility_entity_id',
                            'keyName' => 'facility_name',
                        ])

                        <!-- data error - label -->
                        <hr/>
                        <div class="row"><div class="col-md-3 pull-left"><h3>Student</h3></div></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="first_name">First Name</label>
                            <div class="col-md-8">
                                <input id="first_name" class="form-control" type="text" name="first_name" value="{{ v('first_name') }}" placeholder="First Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="middle_name">Middle Name</label>
                            <div class="col-md-8">
                                <input id="middle_name" class="form-control" type="text" name="middle_name" value="{{ v('middle_name') }}" placeholder="Middle Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="last_name">Last Name</label>
                            <div class="col-md-8">
                                <input id="last_name" class="form-control" type="text" name="last_name" value="{{ v('last_name') }}" placeholder="Last Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="date_of_birth">Date of Birth</label>
                            <div class="col-md-8">
                                <div class="input-group date">
                                    <input id="date_of_birth" class="form-control" type="text" name="date_of_birth" value="{{ v('date_of_birth') }}" placeholder="Date of Birth">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><span
                                                    class="glyphicon glyphicon-calendar"></span></button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="gender">Gender</label>
                            <div class="col-md-8">
                                <label class="radio-inline">
                                    <input type="radio" name="gender" {{ r('gender', 'male') }} id="gender1" value="male">
                                    Male
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" {{ r('gender', 'female') }} id="gender2" value="female">
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
                            <label class="col-md-4 control-label" for="adress1">Adress 1</label>
                            <div class="col-md-8">
                                <input id="adress1" class="form-control" type="text" name="adress1" value="{{ v('adress1') }}" placeholder="Adress 1">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="adress2">Adress 2</label>
                            <div class="col-md-8">
                                <input id="adress2" class="form-control" type="text" name="adress2" value="{{ v('adress2') }}" placeholder="Adress 2">
                            </div>
                        </div>

                        @include('modules.school.Admission.select', [
                            'label'   => 'City',
                            'options' => $admission->cities(),
                            'keyId'   => 'city_id',
                            'keyName' => 'city_name',
                        ])

                        @include('modules.school.Admission.select', [
                            'label'    => 'City Area',
                            'options'  => $admission->cityAreas(),
                            'keyId'    => 'city_area',
                            'keyName'  => 'city_area',
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

                        @include('modules.school.Admission.select', [
                            'label'   => 'Admitted To' ,
                            'options' => $admission->classes(),
                            'keyId'   => 'class_entity_id',
                            'keyName' => 'class_name',
                        ])

                        @include('modules.school.Admission.select', [
                            'label'   => 'Admitted To Class' ,
                            'options' => $admission->classGroups(),
                            'keyId'   => 'class_group_entity_id',
                            'keyName' => 'class_group',
                        ])

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="roll_number">Roll Number</label>
                            <div class="col-md-8">
                                <input id="roll_number" class="form-control" type="text" name="roll_number" value="{{ v('roll_number') }}" placeholder="Roll Number">
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

                        @include('modules.school.Admission.select', [
                            'label'    => 'Caste',
                            'options'  => $admission->castes(),
                            'keyId'    => 'caste_id',
                            'keyName'  => 'caste_name',
                        ])

                        @include('modules.school.Admission.select', [
                            'label'    => 'Religion',
                            'options'  => $admission->religions(),
                            'keyId'    => 'religion_id',
                            'keyName'  => 'religion_name',
                        ])

                        @include('modules.school.Admission.select', [
                            'label'    => 'Communication Language',
                            'options'  => $admission->languages(),
                            'keyId'    => 'language_id',
                            'keyName'  => 'language_name',
                        ])

                        <hr/>
                        <div class="row"><div class="col-md-3 pull-left"><h3>Parent</h3></div></div>

                        @include('modules.school.Admission.select', [
                            'label'   => 'Relationship',
                            'options' => $admission->relationships(),
                            'keyId'   => 'relationship_type_id',
                            'keyName' => 'relationship_name',
                        ])

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="parent_gender">Gender</label>
                            <div class="col-md-8">
                                <label class="radio-inline">
                                    <input type="radio" name="parent_gender" {{ r('parent_gender', 'male') }} id="parent_gender1" value="male">
                                    Male
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="parent_gender" {{ r('parent_gender', 'male') }} id="parent_gender2" value="female">
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

                        @include('modules.school.Admission.select', [
                            'label'    => 'Designation',
                            'options'  => $admission->designations(),
                            'keyId'    => 'designation_id',
                            'keyName'  => 'designation_name',
                        ])

                        <hr/>

                        <div class="row_footer">
                           <div class="col-md-12 text-center grid_footer">
                                <button class="btn btn-primary grid_btn" type="submit">Save</button>
                                <a href="{{ url("/cabinet/admission")}}" class="btn btn-default cancle_btn">Cancel</a>
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
