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

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Campaign</label>
                        <div class="col-md-8">
                            <span class="form-control">{{ selected_dropdown('campaign_entity_id', $client->campaigns(), 'campaign_entity_id', 'campaign_name') }}</span>
                        </div>
                    </div>

                    <hr/>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Organization</label>
                        <div class="col-md-8">
                            <span class="form-control">{{ selected_dropdown('organization_entity_id', $client->organizations(), 'organization_entity_id', 'organization_name') }}</span>
                        </div>
                    </div>

                    <hr/>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Facility</label>
                        <div class="col-md-8">
                            <span class="form-control">{{ selected_dropdown('facility_entity_id', $client->facilities(), 'facility_entity_id', 'facility_name') }}</span>
                        </div>
                    </div>

                    <hr/>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Contact Person</label>
                        <div class="col-md-8">
                            <span class="form-control">{{ selected_dropdown('contact_entity_id', $client->contacts(), 'contact_entity_id', 'contact_name') }}</span>
                        </div>
                    </div>

                    <hr/>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Agent</label>
                        <div class="col-md-8">
                            <span class="form-control">{{ selected_dropdown('agent_entity_id', $client->agents(), 'individual_entity_id', 'agent_name') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Status</label>
                        <div class="col-md-8">
                            <span class="form-control">{{ selected_dropdown('client_status_id', $client->statuses(), 'client_status_id', 'client_status') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Visit Date</label>
                        <div class="col-md-8">
                            <span class="form-control">{{ v('visit_date') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Next Visit Date</label>
                        <div class="col-md-8">
                            <span class="form-control">{{ v('next_visit_date') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Notes</label>
                        <div class="col-md-8">
                            <span class="form-control">{{ v('notes') }}</span>
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
