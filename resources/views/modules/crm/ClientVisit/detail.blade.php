@extends('layout.cabinet')

@section('title', 'Client Visit')

@section('content')
<div class="row">
    <div class="col-md-8 sch_class panel-group panel-bdr">
        <div class="panel panel-primary">
		    <div class="panel-heading">
            	<i class="glyphicon glyphicon-th"></i>
            	<h3>Client Visit - Details</h3>
            </div>

            <div class="panel-body edit_form_wrapper">
                <section class="form_panel">

                @include('commons.errors')

                <form class="form-horizontal" action="{{ form_action() }}" method="POST">

<hr/>
<div class="row"><div class="col-md-3 pull-left"><h3>Campaign</h3></div></div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Campaign</label>
                        <div class="col-md-8">
                            <span class="form-control">{{ $client->campaign_name }}</span>
                        </div>
                    </div>

<hr/>
<div class="row"><div class="col-md-3 pull-left"><h3>Organization</h3></div></div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Organization</label>
                        <div class="col-md-8">
                            <span class="form-control">{{ $client->organization_name }}</span>
                        </div>
                    </div>

<hr/>
<div class="row"><div class="col-md-3 pull-left"><h3>Facility</h3></div></div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Facility</label>
                        <div class="col-md-8">
                            <span class="form-control">{{ $client->facility_name }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Facility City</label>
                        <div class="col-md-8">
                            <span class="form-control">{{ $client->facility_city_name }}</span>
                        </div>
                    </div>

<hr/>
<div class="row"><div class="col-md-3 pull-left"><h3>Contact Person</h3></div></div>


                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Contact First Name</label>
                        <div class="col-md-8">
                            <span class="form-control">{{ $client->contact_first_name }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Contact Mobile Phone</label>
                        <div class="col-md-8">
                            <span class="form-control">{{ phone_number($client->contact_mobile_phone) }}</span>
                        </div>
                    </div>

<hr/>
<div class="row"><div class="col-md-3 pull-left"><h3>Visit</h3></div></div>


                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Agent Name</label>
                        <div class="col-md-8">
                            <span class="form-control">{{ $client->agent_name }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Agent Mobile Phone</label>
                        <div class="col-md-8">
                            <span class="form-control">{{ phone_number($client->agent_mobile_phone) }}</span>
                        </div>
                    </div>

                    <hr/>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Product Name</label>
                        <div class="col-md-8">
                            <span class="form-control">{{ $client->product_name }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Unit Type</label>
                        <div class="col-md-8">
                            <span class="form-control">{{ $client->unit_type }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Expeced Units</label>
                        <div class="col-md-8">
                            <span class="form-control">{{ $client->expected_units }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Commited Price</label>
                        <div class="col-md-8">
                            <span class="form-control">&#x20b9; {{ amount($client->commited_price) }}</span>
                        </div>
                    </div>

                    <hr/>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Visit Date</label>
                        <div class="col-md-8">
                            <span class="form-control">{{ style_date($client->visit_date) }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Visit Type</label>
                        <div class="col-md-8">
                            <span class="form-control">{{ $client->visit_type }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Next Visit Date</label>
                        <div class="col-md-8">
                            <span class="form-control">{{ style_date($client->next_visit_date) }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Next Visit Type</label>
                        <div class="col-md-8">
                            <span class="form-control">{{ $client->next_visit_type }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Client Status</label>
                        <div class="col-md-8">
                            <span class="form-control">{{ $client->client_status }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Notes</label>
                        <div class="col-md-8">
                            <span class="form-control">{{ $client->notes }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <a href="{{ url("/cabinet/client-visit")}}" class="btn btn-default cancle_btn">Back</a>
                        </div>
                    </div>
                    <br/>
                </form>

                </section>
            </div>
        </div>
    </div>
</div>
@endsection
