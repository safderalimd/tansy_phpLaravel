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

                    <form class="form-horizontal" action="{{ form_action() }}" method="POST">
                        {{ csrf_field() }}

                        <hr/>
                        <div class="row"><div class="col-md-3 pull-left"><h3>Header</h3></div></div>


                        @include('commons.select', [
                            'label'   => 'Organization',
                            'name'    => 'organization_entity_id',
                            'options' => $account->organizations(),
                            'keyId'   => 'organization_entity_id',
                            'keyName' => 'organization_name',
                        ])

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="facility_ids">Facility</label>
                            <div class="col-md-8">
                                <?php
                                    if (!is_array($account->selectedFacilities)) {
                                        $account->selectedFacilities = [];
                                    }
                                ?>
                                <select id="facility_ids" class="form-control" name="facility_ids">
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

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <div class="checkbox">
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

                        <hr/>
                        <div class="row"><div class="col-md-3 pull-left"><h3>Agent</h3></div></div>

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
                        <div class="row"><div class="col-md-3 pull-left"><h3>Agent Info</h3></div></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="login_name">Login Name</label>
                            <div class="col-md-8">
                                <input id="login_name" class="form-control" type="text" name="login_name" value="{{ v('login_name') }}" placeholder="Login Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="field_password">Password</label>
                            <div class="col-md-8">
                                <input id="field_password" class="form-control" type="text" name="field_password" value="{{ v('password') }}" placeholder="Password">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <div class="checkbox">
                                    <label>
                                        <input {{ c('user_account_active') }} name="user_account_active" type="checkbox"> User Account Active
                                    </label>
                                </div>
                            </div>
                        </div>

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

        initOrganizationOptions();
    });

    var allFacilityOptions;

    function initOrganizationOptions() {
        allFacilityOptions = $('#facility_ids option');

        var selectedOrganizationId = $('#facility_ids option:selected').attr('data-organizationId');

        $('#organization_entity_id option').each(function() {
            if (this.value == selectedOrganizationId) {
                $(this).prop('selected',true);
            }
        });

        updateFacilities();
    }

    function getOrganizationId() {
        return $('#organization_entity_id option:selected').val();
    }

    function removeAllFacilityOptions() {
        $('#facility_ids option').remove();
    }

    function populateFacilitiesSelectbox(facilities) {
        $(facilities).each(function() {
            $('#facility_ids').append($(this));
        });
    }

    function updateFacilities() {
        removeAllFacilityOptions();

        var orgId = getOrganizationId();
        var filteredFacilities = $(allFacilityOptions).filter(function() {
            if ($(this).attr('data-organizationId') == orgId) {
                return true;
            }
            return false;
        }).get();

        populateFacilitiesSelectbox(filteredFacilities);
    }

    $('#organization_entity_id').change(function() {
        updateFacilities();
    });

</script>
@endsection

