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

                    <hr/>

                    @include('commons.select', [
                        'label'   => 'Campaign' ,
                        'name'    => 'campaign_entity_id',
                        'options' => $client->campaigns(),
                        'keyId'   => 'campaign_entity_id',
                        'keyName' => 'campaign_name',
                    ])


                    <hr/>
                    <div class="row"><div class="col-md-3 pull-left"><h3>Organization</h3></div></div>


                    @include('commons.select', [
                        'label'   => 'Organization' ,
                        'name'    => 'organization_entity_id',
                        'options' => $client->organizations(),
                        'keyId'   => 'organization_entity_id',
                        'keyName' => 'organization_name',
                    ])

                    @include('modules.crm.ClientVisit.new-organization')


                    <hr/>
                    <div class="row"><div class="col-md-3 pull-left"><h3>Facility</h3></div></div>


                    @include('commons.select', [
                        'label'   => 'Facility' ,
                        'name'    => 'facility_entity_id',
                        'options' => $client->facilities(),
                        'keyId'   => 'facility_entity_id',
                        'keyName' => 'facility_name',
                    ])

                    @include('modules.crm.ClientVisit.new-facility')


                    <hr/>
                    <div class="row"><div class="col-md-3 pull-left"><h3>Contact Person</h3></div></div>


                    @include('commons.select', [
                        'label'   => 'Contact Person' ,
                        'name'    => 'contact_entity_id',
                        'options' => $client->contacts(),
                        'keyId'   => 'contact_entity_id',
                        'keyName' => 'contact_name',
                    ])

                    @include('modules.crm.ClientVisit.new-contact')


                    <hr/>
                    <div class="row"><div class="col-md-3 pull-left"><h3>Visit</h3></div></div>


                    @include('commons.select', [
                        'label'   => 'Agent' ,
                        'name'    => 'agent_entity_id',
                        'options' => $client->agents(),
                        'keyId'   => 'individual_entity_id',
                        'keyName' => 'agent_name',
                    ])

                    @include('commons.select', [
                        'label'   => 'Status' ,
                        'name'    => 'client_status_id',
                        'options' => $client->statuses(),
                        'keyId'   => 'client_status_id',
                        'keyName' => 'client_status',
                    ])

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="visit_date">Visit Date</label>
                        <div class="col-md-8">
                            <div class="input-group date">
                                <input id="visit_date" class="form-control" type="text" name="visit_date" value="{{ v('visit_date') }}" placeholder="Visit Date">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><span
                                                class="glyphicon glyphicon-calendar"></span></button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="next_visit_date">Next Visit Date</label>
                        <div class="col-md-8">
                            <div class="input-group date">
                                <input id="next_visit_date" class="form-control" type="text" name="next_visit_date" value="{{ v('next_visit_date') }}" placeholder="Next Visit Date">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><span
                                                class="glyphicon glyphicon-calendar"></span></button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-md-4 control-label" for="status">Notes</label>
                        <div class="col-md-8">
                            <textarea maxlength="160" id="notes" name="notes" class="form-control" rows="4">{{old('notes')}}</textarea>
                        </div>
                    </div>

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

@section('scripts')
<script type="text/javascript">

    $(document).ready(function(){

        $('.new-checkbox').change(function() {
            var selectId = '#' + $(this).attr('data-selectid');
            if($(this).is(":checked")) {
                $(this).closest('.new-checkbox-group').find('.new-checkbox-inputs').fadeIn();
                $(selectId).prop('disabled', true);
            } else {
                $(this).closest('.new-checkbox-group').find('.new-checkbox-inputs').fadeOut();
                $(selectId).prop('disabled', false);
            }
        });

        $('#organization_city_area').combobox({
            bsVersion: '3',
            newTarget: '#organization_city_area_new'
        });

        $('#facility_city_area').combobox({
            bsVersion: '3',
            newTarget: '#facility_city_area_new'
        });

    });

</script>
@endsection
