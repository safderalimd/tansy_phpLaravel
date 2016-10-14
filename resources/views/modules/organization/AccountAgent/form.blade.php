@extends('layout.cabinet')

@section('title', 'Account Agent')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th"></i>
                    <h3>Account Agent{{ form_label() }}</h3>
                </div>

                <div class="panel-body edit_form_wrapper">
                    <section class="form_panel">

                    @include('commons.errors')

                    <form autocomplete="off" id="account-agent-form" class="form-horizontal" action="{{ form_action() }}" method="POST">
                        {{ csrf_field() }}

<hr/>
<div class="row">
    <div class="col-md-4 pull-left"><h3>Header</h3></div>
    <div class="col-md-4">
        <div class="checkbox header-active-checkbox">
            <label>
                @if($account->isNewRecord())
                    <input checked="checked" name="active" type="checkbox" disabled readonly> Active
                @else
                    <input {{ c('active') }} name="active" type="checkbox"> Active
                @endif
            </label>
        </div>
    </div>
</div>


                        @include('commons.select', [
                            'label'    => 'Organization',
                            'name'     => 'organization_entity_id',
                            'options'  => $account->agentOrganizations(),
                            'keyId'    => 'organization_entity_id',
                            'keyName'  => 'organization_name',
                            'none'     => 'Select an organization..',
                            'required' => true,
                        ])

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="facility_ids">Facility</label>
                            <div class="col-md-8">
                                <?php
                                    if (!is_array($account->selectedFacilities)) {
                                        $account->selectedFacilities = [];
                                    }
                                ?>
                                <select id="facility_ids" class="form-control" name="facility_ids">
                                    <option value="none">Select a facility..</option>
                                    @if ($account->isNewRecord())
                                        @foreach($account->facilities() as $option)
                                            <option {{ s('facility_ids', $option['facility_entity_id']) }} data-organizationId="{{$option['organization_entity_id']}}" value="{{$option['facility_entity_id']}}">{{$option['facility_name']}}</option>
                                        @endforeach
                                    @else
                                        @foreach($account->facilities() as $option)
                                            <option data-organizationId="{{$option['organization_entity_id']}}" @if(in_array($option['facility_entity_id'], $account->selectedFacilities)) selected @endif value="{{$option['facility_entity_id']}}">{{$option['facility_name']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

<hr/>
<div class="row"><div class="col-md-3 pull-left"><h3>Agent</h3></div></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="first_name">First Name</label>
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
                                    <input type="radio" name="gender" {{ r('gender', 'M') }} id="gender1" value="M">
                                    Male
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" {{ r('gender', 'F') }} id="gender2" value="F">
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
                            <label class="col-md-4 control-label" for="work_phone">Work Phone</label>
                            <div class="col-md-8">
                                <input id="work_phone" class="form-control" type="text" name="work_phone" value="{{ v('work_phone') }}" placeholder="Work Phone">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="mobile_phone">Mobile Phone</label>
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
                            'label'    => 'City',
                            'name'     => 'city_id',
                            'options'  => $account->cities(),
                            'keyId'    => 'city_id',
                            'keyName'  => 'city_name',
                            'none'     => 'Select a city..',
                            'required' => true,
                        ])

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="city_area">City Area</label>
                            <div class="col-md-8">
                                <select autocomplete="new-password" id="city_area" class="form-control" name="city_area">
                                    <option></option>
                                    <?php
                                        $cityAreaValue = '';
                                    ?>
                                    @foreach($account->cityAreas() as $option)
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

                        <input type="text" name="tmp-name" style="display:none">
                        <input type="password" name="tmp-pass" style="display:none">

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="login_name">Login Name</label>
                            <div class="col-md-8">
                                <input autocomplete="off" id="login_name" class="form-control" type="text" name="login_name" value="{{ v('login_name') }}" placeholder="Login Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="password">Password</label>
                            <div class="col-md-8">
                                <input autocomplete="off" id="password" class="form-control" type="password" name="password" value="{{ v('password') }}" placeholder="Password">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <div class="checkbox">
                                    <label>
                                        <input {{ c('login_active') }} id="login_active" name="login_active" type="checkbox"> Login Active
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="security_group_entity_id">Security Group</label>
                            <div class="col-md-8">
                                <select disabled="disabled" id="security_group_entity_id" class="form-control" name="security_group_entity_id">
                                    @foreach($account->securityGroupForAgent() as $option)
                                        <option value="{{ $option['security_group_entity_id'] }}">{{ $option['security_group'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @include('commons.select', [
                            'label'    => 'Default Facility',
                            'name'     => 'view_default_facility_id',
                            'options'  => $account->facilities(),
                            'keyId'    => 'facility_entity_id',
                            'keyName'  => 'facility_name',
                            'data'     => 'organization_entity_id',
                            'dataName' => 'organizationId',
                            'none'     => 'Select a default facility..',
                        ])

                        <div class="row">
                           <div class="col-md-12 text-center grid_footer">
                                <button class="btn btn-primary grid_btn" type="submit">Save</button>
                                <a href="{{ url("/cabinet/account-agent")}}" class="btn btn-default cancle_btn">Cancel</a>
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
<script type="text/javascript">

    $(document).ready(function(){
        $('#city_area').combobox({
            bsVersion: '3'
        });

        filterSelectbox({
            firstId: '#organization_entity_id',
            firstFilter: 'value',
            secondId: '#facility_ids',
            secondFilter: 'data-organizationId',
            initFirstSelect: true
        });

        filterSelectbox({
            firstId: '#organization_entity_id',
            firstFilter: 'value',
            secondId: '#view_default_facility_id',
            secondFilter: 'data-organizationId',
            initAgain: true
        });

        updateDocumentNumberRules();
        updateRules();
    });


    function updateDocumentNumberRules() {
        notRequired('#document_number');
        $('#document_number').rules('remove', 'required');

        if ($('#document_type_id option:selected').val() != 'none') {
            $('#document_number').rules('add', 'required');
            makeRequired('#document_number');
        }
    }

    $('#document_type_id').change(function() {
        updateDocumentNumberRules();
        $('#document_number').valid();
    });

    $('#login_active').change(function() {
        updateRules();
        $('#security_group_entity_id').valid();
        $('#view_default_facility_id').valid();
    });

    function updateRules() {
        notRequired('#security_group_entity_id');
        $('#security_group_entity_id').rules('remove', 'requiredSelect');
        notRequired('#view_default_facility_id');
        $('#view_default_facility_id').rules('remove', 'requiredSelect');

        if ($('#login_active').is(':checked')) {
            $('#security_group_entity_id').rules('add', 'requiredSelect');
            makeRequired('#security_group_entity_id');

            $('#view_default_facility_id').rules('add', 'requiredSelect');
            makeRequired('#view_default_facility_id');
        }
    }

    var rules = {
        facility_ids: {
            requiredSelect: true
        },
        organization_entity_id: {
            requiredSelect: true
        },
        first_name: {
            required: true,
            maxlength: 30
        },
        middle_name: {
            maxlength: 30
        },
        last_name: {
            maxlength: 30
        },
        date_of_birth: {
            dateISO: true
        },
        email: {
            email: true
        },
        work_phone: {
            phoneNumber: true
        },
        mobile_phone: {
            required: true,
            phoneNumber: true
        },
        address1: {
            maxlength: 128
        },
        address2: {
            maxlength: 128
        },
        postal_code: {
            maxlength: 30
        },
        login_name: {
            maxlength: 128,
            notAtSymbol: true
        },
        password: {
            minlength: 8,
            maxlength: 128
        },
        city_id: {
            requiredSelect: true
        }
    };

    $('#account-agent-form').validate({
        rules: rules
    });

    function makeRequired(elem) {
        $(elem).closest('.form-group').find('.control-label').addClass('required');
    }

    function notRequired(elem) {
        $(elem).closest('.form-group').find('.control-label').removeClass('required');
    }

    $('#date_of_birth').change(function() {
        $('#date_of_birth').valid();
    });

</script>
@endsection

