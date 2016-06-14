@extends('layout.cabinet')

@section('title', 'Organization')

@section('content')
<div class="row">
    <div class="col-md-8 sch_class panel-group panel-bdr">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-th"></i>
                <h3>Organization{!! form_label() !!}</h3>
            </div>

            <div class="panel-body edit_form_wrapper">
                <section class="form_panel">

                @include('commons.errors')

                <form class="form-horizontal" action="{{ form_action() }}" method="POST">
                    {{ csrf_field() }}

<hr/>
<div class="row"><div class="col-md-4 pull-left"><h3>Organization Header</h3></div></div>

                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <div class="checkbox">
                                <label>
                                    <input checked="checked" name="active" type="checkbox" disabled readonly> Active
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="product">Organization Name</label>
                        <div class="col-md-8">
                            <input id="organization_name" class="form-control" type="text" name="organization_name" value="{{ v('organization_name') }}" placeholder="Organization Name">
                        </div>
                    </div>

                    @include('commons.select', [
                        'label'   => 'Organization Type' ,
                        'name'    => 'organization_type_id',
                        'options' => $organization->organizationTypes(),
                        'keyId'   => 'organization_type_id',
                        'keyName' => 'organization_type',
                    ])

<hr/>
<div class="row"><div class="col-md-4 pull-left"><h3>Organization Contact</h3></div></div>

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
<div class="row"><div class="col-md-4 pull-left"><h3>Organization Adress</h3></div></div>

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
                        'options' => $organization->cities(),
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
                                @foreach($organization->cityAreas() as $option)
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

<div class="new-checkbox-group">
    <div class="form-group">
        <div class="col-md-offset-4 col-md-3">
            <div class="checkbox">
                <label style="padding-left:20px;">
                    <input id="create_new_facility" name="create_new_facility" class="new-checkbox" type="checkbox"> New Facility
                </label>
            </div>
        </div>
    </div>

    <div class="new-checkbox-inputs" style="display:none;">

        <hr/>
        <div class="row"><div class="col-md-4 pull-left"><h3>Facility Header</h3></div></div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="facility_name">Name</label>
            <div class="col-md-8">
                <input id="facility_name" class="form-control" type="text" name="facility_name" value="{{ v('facility_name') }}" placeholder="Name">
            </div>
        </div>

        @include('commons.select', [
            'label'   => 'Facility Type' ,
            'name'    => 'facility_type_id',
            'options' => $organization->facilityTypes(),
            'keyId'   => 'facility_type_id',
            'keyName' => 'facility_type',
        ])

        <hr/>
        <div class="row"><div class="col-md-4 pull-left"><h3>Facility Contact</h3></div></div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="facility_email">Email</label>
            <div class="col-md-8">
                <input id="facility_email" class="form-control" type="email" name="facility_email" value="{{ v('facility_email') }}" placeholder="Email">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="facility_work_phone">Phone Number</label>
            <div class="col-md-8">
                <input id="facility_work_phone" class="form-control" type="text" name="facility_work_phone" value="{{ v('facility_work_phone') }}" placeholder="Phone Number">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="facility_mobile_phone">Mobile Number</label>
            <div class="col-md-8">
                <input id="facility_mobile_phone" class="form-control" type="text" name="facility_mobile_phone" value="{{ v('facility_mobile_phone') }}" placeholder="Mobile Number">
            </div>
        </div>

        <hr/>
        <div class="row"><div class="col-md-4 pull-left"><h3>Facility Adress</h3></div></div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="facility_address1">Adress 1</label>
            <div class="col-md-8">
                <input id="facility_address1" class="form-control" type="text" name="facility_address1" value="{{ v('facility_address1') }}" placeholder="Adress 1">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="facility_address2">Adress 2</label>
            <div class="col-md-8">
                <input id="facility_address2" class="form-control" type="text" name="facility_address2" value="{{ v('facility_address2') }}" placeholder="Adress 2">
            </div>
        </div>

        @include('commons.select', [
            'label'   => 'City' ,
            'name'    => 'facility_city_id',
            'options' => $organization->cities(),
            'keyId'   => 'city_id',
            'keyName' => 'city_name',
        ])

        <div class="form-group">
            <label class="col-md-4 control-label" for="facility_city_area">City Area</label>
            <div class="col-md-8">
                <select autocomplete="off" id="facility_city_area" class="form-control" name="facility_city_area">
                    <option></option>
                    <?php
                        $cityAreaValue = '';
                    ?>
                    @foreach($organization->cityAreas() as $option)
                        <?php
                            if (old('facility_city_area') == $option['city_area']) {
                                $cityAreaValue = $option['city_area'];
                            }
                        ?>
                        <option {{ s('facility_city_area', $option['city_area']) }} value="{{ $option['city_area'] }}">{{ $option['city_area'] }}</option>
                    @endforeach
                </select>
                <input type="hidden" value="{{$cityAreaValue}}" name="facility_city_area_new" id="facility_city_area_new">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="facility_postal_code">Postal Code</label>
            <div class="col-md-8">
                <input id="facility_postal_code" class="form-control" type="text" name="facility_postal_code" value="{{ v('facility_postal_code') }}" placeholder="Postal Code">
            </div>
        </div>

    </div>
</div>



                    <div class="row">
                       <div class="col-md-12 text-center grid_footer">
                            <button class="btn btn-primary grid_btn" type="submit">Save</button>
                            <a href="{{ url("/cabinet/organizations")}}" class="btn btn-default cancle_btn">Cancel</a>
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

        $('#create_new_facility').change(function() {
            if($(this).is(":checked")) {
                copyOrganizationInfoToFacility();
                $(this).closest('.new-checkbox-group').find('.new-checkbox-inputs').fadeIn();
            } else {
                $(this).closest('.new-checkbox-group').find('.new-checkbox-inputs').fadeOut();
            }
        });

        function copyOrganizationInfoToFacility() {

            var orgName = $('#organization_name').val();

            var orgEmail = $('#email').val();
            var orgWorkPhone = $('#work_phone').val();
            var orgMobilePhone = $('#mobile_phone').val();

            var orgAddress1 = $('#address1').val();
            var orgAddress2 = $('#address2').val();
            var orgCityId = $('#city_id option:selected').val();
            var orgCityAreaNew = $('#city_area_new').val();
            var orgPostalCode = $('#postal_code').val();

            $('#facility_name').val(orgName);
            $('#facility_email').val(orgEmail);
            $('#facility_work_phone').val(orgWorkPhone);
            $('#facility_mobile_phone').val(orgMobilePhone);
            $('#facility_address1').val(orgAddress1);
            $('#facility_address2').val(orgAddress2);
            $('#facility_postal_code').val(orgPostalCode);

            $('#facility_city_id option').each(function() {
                if (this.value == orgCityId) {
                    $(this).prop('selected', true);
                } else {
                    $(this).prop('selected', false);
                }
            });

            if (orgCityAreaNew.trim()) {
                $('#facility_city_area').append($("<option></option>")
                    .attr("value", orgCityAreaNew)
                    .text(orgCityAreaNew));
                $('#facility_city_area_new').val(orgCityAreaNew);
                $('#facility_city_area').val(orgCityAreaNew);
                $('#facility_city_area').data('combobox').refresh();
            }
        }

        $('#city_area').combobox({
            bsVersion: '3',
            newTarget: '#city_area_new'
        });

        $('#facility_city_area').combobox({
            bsVersion: '3',
            newTarget: '#facility_city_area_new'
        });

    });

</script>
@endsection
