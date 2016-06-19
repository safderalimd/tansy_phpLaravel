<div class="new-checkbox-group">
    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            <div class="checkbox">
                <label style="padding-left:20px;">
                    <input data-selectid="organization_entity_id" name="organization_new" id="organization_new" class="new-checkbox" type="checkbox"> New
                </label>
            </div>
        </div>
    </div>

    <div class="new-checkbox-inputs" style="display:none;">
        <div class="form-group">
            <label class="col-md-4 control-label" for="organization_name">Name</label>
            <div class="col-md-8">
                <input id="organization_name" class="form-control" type="text" name="organization_name" value="{{ v('organization_name') }}" placeholder="Name">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="organization_address1">Adress 1</label>
            <div class="col-md-8">
                <input id="organization_address1" class="form-control" type="text" name="organization_address1" value="{{ v('organization_address1') }}" placeholder="Adress 1">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="organization_address2">Adress 2</label>
            <div class="col-md-8">
                <input id="organization_address2" class="form-control" type="text" name="organization_address2" value="{{ v('organization_address2') }}" placeholder="Adress 2">
            </div>
        </div>

        @include('commons.select', [
            'label'   => 'City' ,
            'name'    => 'organization_city_id',
            'options' => $client->cities,
            'keyId'   => 'city_id',
            'keyName' => 'city_name',
            'none'    => 'Select a city..',
        ])

        <div class="form-group">
            <label class="col-md-4 control-label" for="organization_city_area">City Area</label>
            <div class="col-md-8">
                <select autocomplete="off" id="organization_city_area" class="form-control" name="organization_city_area">
                    <option></option>
                    <?php
                        $cityAreaValue = '';
                    ?>
                    @foreach($client->cityAreas as $option)
                        <?php
                            if (old('organization_city_area') == $option['city_area']) {
                                $cityAreaValue = $option['city_area'];
                            }
                        ?>
                        <option {{ s('organization_city_area', $option['city_area']) }} value="{{ $option['city_area'] }}">{{ $option['city_area'] }}</option>
                    @endforeach
                </select>
                <input type="hidden" value="{{$cityAreaValue}}" name="organization_city_area_new" id="organization_city_area_new">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="organization_work_phone">Phone Number</label>
            <div class="col-md-8">
                <input id="organization_work_phone" class="form-control" type="text" name="organization_work_phone" value="{{ v('organization_work_phone') }}" placeholder="Phone Number">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="organization_mobile_phone">Mobile Number</label>
            <div class="col-md-8">
                <input id="organization_mobile_phone" class="form-control" type="text" name="organization_mobile_phone" value="{{ v('organization_mobile_phone') }}" placeholder="Mobile Number">
            </div>
        </div>

    </div>
</div>
