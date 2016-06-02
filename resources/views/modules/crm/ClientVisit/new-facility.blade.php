<div class="new-checkbox-group">
    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            <div class="checkbox">
                <label style="padding-left:20px;">
                    <input data-selectid="facility_entity_id" name="facility_new" class="new-checkbox" type="checkbox"> New
                </label>
            </div>
        </div>
    </div>

    <div class="new-checkbox-inputs" style="display:none;">

        @include('commons.select', [
            'label'   => 'Facility Type' ,
            'name'    => 'facility_type_id',
            'options' => $client->facilityTypes(),
            'keyId'   => 'facility_type_id',
            'keyName' => 'facility_type',
        ])

        <div class="form-group">
            <label class="col-md-4 control-label" for="facility_name">Name</label>
            <div class="col-md-8">
                <input id="facility_name" class="form-control" type="text" name="facility_name" value="{{ v('facility_name') }}" placeholder="Name">
            </div>
        </div>

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

        <div class="form-group">
            <label class="col-md-4 control-label" for="facility_city">City</label>
            <div class="col-md-8">
                <input id="facility_city" class="form-control" type="text" name="facility_city" value="{{ v('facility_city') }}" placeholder="City">
            </div>
        </div>

        @include('commons.select', [
            'label'   => 'City' ,
            'name'    => 'facility_city_id',
            'options' => $client->cities,
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
                    @foreach($client->cityAreas as $option)
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

    </div>
</div>
