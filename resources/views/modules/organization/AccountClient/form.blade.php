@extends('layout.cabinet')

@section('title', 'Account Client')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th"></i>
                    <h3>Account Client{{ form_label() }}</h3>
                </div>

                <div class="panel-body edit_form_wrapper">
                    <section class="form_panel">

                    @include('commons.errors')

                    <form id="client-visit-form" class="form-horizontal" action="{{ form_action() }}" method="POST">
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
                                    @foreach($account->facilitiesForOwner() as $option)
                                        <option @if(in_array($option['facility_entity_id'], $account->selectedFacilities)) selected @endif value="{{$option['facility_entity_id']}}">{{$option['facility_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="unique_key_id">Identification</label>
                            <div class="col-md-8">
                                <select id="unique_key_id" class="form-control" name="unique_key_id">
                                    <option value="none">Select an identification..</option>
                                    @foreach($account->identifications() as $option)
                                        @if ($account->isNewRecord())
                                            <option @if($option['default_value']) selected @endif value="{{ $option['unique_key_id'] }}">{{ $option['unique_key'] }}</option>
                                        @else
                                            <option {{s('unique_key_id', $option['unique_key_id'])}} value="{{ $option['unique_key_id'] }}">{{ $option['unique_key'] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

<hr/>
<div class="row"><div class="col-md-3 pull-left"><h3>Client Info</h3></div></div>

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

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="city_area">City Area</label>
                            <div class="col-md-8">
                                <select autocomplete="off" id="city_area" class="form-control" name="city_area">
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


                        <div class="row">
                           <div class="col-md-12 text-center grid_footer">
                                <button class="btn btn-primary grid_btn" type="submit">Save</button>
                                <a href="{{ url("/cabinet/account-client")}}" class="btn btn-default cancle_btn">Cancel</a>
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

    var rules = {
        facility_ids: {
            requiredSelect: true
        },
        unique_key_id: {
            requiredSelect: true
        },
        first_name: {
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
        gender: {

        },
        email: {
            email: true
        },
        work_phone: {
            phoneNumber: true
        },
        mobile_phone: {
            phoneNumber: true
        },
        address1: {
            maxlength: 128
        },
        address2: {
            maxlength: 128
        },
        city_id: {

        },
        postal_code: {
            maxlength: 30
        },
        document_type_id: {

        },
        document_number: {

        }
    };

    $('#client-visit-form').validate({
        rules: rules
    });

    $('#date_of_birth').change(function() {
        $('#date_of_birth').valid();
    });

    $('#unique_key_id').change(function() {
        updateRules();
        $('#client-visit-form').valid();
    });

    function makeRequired(elem) {
        $(elem).closest('.form-group').find('.control-label').addClass('required');
    }

    function notRequired(elem) {
        $(elem).closest('.form-group').find('.control-label').removeClass('required');
    }

    function removeRequired() {
        notRequired('#first_name');
        $('#first_name').rules('remove', 'required');
        notRequired('#last_name');
        $('#last_name').rules('remove', 'required');
        notRequired('#date_of_birth');
        $('#date_of_birth').rules('remove', 'required');
        notRequired('#mobile_phone');
        $('#mobile_phone').rules('remove', 'required');
        notRequired('#address1');
        $('#address1').rules('remove', 'required');
        notRequired('#email');
        $('#email').rules('remove', 'required');
    }

    function updateRules() {
        var type = $('#unique_key_id option:selected').text();
        type = type.toLowerCase().trim();

        removeRequired();

        if (type == 'first and last name') {
            $('#first_name').rules('add', 'required'); makeRequired('#first_name');
            $('#last_name').rules('add', 'required'); makeRequired('#last_name');

        } else if (type == 'name and date of birth') {
            $('#first_name').rules('add', 'required'); makeRequired('#first_name');
            $('#last_name').rules('add', 'required'); makeRequired('#last_name');
            $('#date_of_birth').rules('add', 'required'); makeRequired('#date_of_birth');

        } else if (type == 'mobile number') {
            $('#mobile_phone').rules('add', 'required'); makeRequired('#mobile_phone');

        } else if (type == 'address line1') {
            $('#address1').rules('add', 'required'); makeRequired('#address1');

        } else if (type == 'email') {
            $('#email').rules('add', 'required'); makeRequired('#email');
        }
    }

    $(document).ready(function(){
        $('#city_area').combobox({
            bsVersion: '3'
        });

        // init identification rules
        updateRules();
    });

</script>
@endsection
