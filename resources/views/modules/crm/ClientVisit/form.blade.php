@extends('layout.cabinet')

@section('title', 'Client Visit')

@section('content')
<div class="row">
    <div class="col-md-8 sch_class panel-group panel-bdr">
        <div class="panel panel-primary">
		    <div class="panel-heading">
            	<i class="glyphicon glyphicon-th"></i>
            	<h3>Client Visit{!! form_label() !!}</h3>
            </div>

            <div class="panel-body edit_form_wrapper">
                <section class="form_panel">

                @include('commons.errors')

                <form class="form-horizontal" action="{{ form_action() }}" method="POST">
                    {{ csrf_field() }}

                    <!-- if($client->isNewRecord()) -->
                    @include('commons.select', [
                        'label'   => 'Facility' ,
                        'name'    => 'facility_entity_id',
                        'options' => $client->facilities(),
                        'keyId'   => 'facility_entity_id',
                        'keyName' => 'facility_name',
                    ])

                    @include('commons.select', [
                        'label'   => 'Organization' ,
                        'name'    => 'organization_entity_id',
                        'options' => $client->organizations(),
                        'keyId'   => 'organization_entity_id',
                        'keyName' => 'organization_name',
                    ])

                    <!--

                        campaign dropdown

                        -organization-
                        organizaition dropdown
                        new checkbox
                        name
                        address1          address2
                        city              city_area
                        phone_number      mobile_number

                        -facility-
                        facility dropdown
                        new checkbox
                        name
                        address1          address2
                        city              city_area
                        phone_number      mobile_number

                        -contact person-
                        contact person dropdown
                        new checkbox
                        first name             last name
                        email
                        phone number           mobile number

                        visit date
                        agent
                        status
                        notes


                    -->



           			<div class="form-group">
                        <label class="col-md-4 control-label" for="product">Product Name</label>
                        <div class="col-md-8">
                            <input id="product" class="form-control" type="text" name="product_name" value="{{ v('product_name') }}" placeholder="Product Name">
                        </div>
                    </div>

<!--                     include('commons.select', [
                        'label'   => 'Product Type' ,
                        'name'    => 'product_type_entity_id',
                        'options' => $client->productTypes(),
                        'keyId'   => 'product_type_entity_id',
                        'keyName' => 'product_type',
                    ])
 -->

                    <div class="row">
                       <div class="col-md-12 text-center grid_footer">
                            <button class="btn btn-primary grid_btn" type="submit">Save</button>
                            <a href="{{ url("/cabinet/client-visit")}}" class="btn btn-default cancle_btn">Cancel</a>
                        </div>
                    </div>
                </form>

                </section>
            </div>
        </div>
    </div>
</div>
@endsection
