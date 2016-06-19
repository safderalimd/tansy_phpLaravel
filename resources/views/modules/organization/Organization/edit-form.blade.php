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
                    <div class="row"><div class="col-md-3 pull-left"><h3>Header</h3></div></div>

                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <div class="checkbox">
                                <label>
                                    <input {{ c('active') }} name="active" type="checkbox"> Active
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="product">Organization Name</label>
                        <div class="col-md-8">
                            <input id="organization" class="form-control" type="text" name="organization_name" value="{{ v('organization_name') }}" placeholder="Organization Name">
                        </div>
                    </div>

                    @include('commons.select', [
                        'label'   => 'Organization Type' ,
                        'name'    => 'organization_type_id',
                        'options' => $organization->organizationTypes(),
                        'keyId'   => 'organization_type_id',
                        'keyName' => 'organization_type',
                        'none'    => 'Select an organization type..',
                    ])

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
                        'options' => $organization->cities(),
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
        $('#city_area').combobox({
            bsVersion: '3'
        });
    });

</script>
@endsection
