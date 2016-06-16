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
                        'options' => $client->clientOrganizations(),
                        'keyId'   => 'organization_entity_id',
                        'keyName' => 'organization_name',
                        'none'    => 'Select an organization..',
                    ])

                    @include('modules.crm.ClientVisit.new-organization')


                    <hr/>
                    <div class="row"><div class="col-md-3 pull-left"><h3>Facility</h3></div></div>

                    @include('commons.select', [
                        'label'    => 'Facility',
                        'name'     => 'facility_entity_id',
                        'options'  => $client->facilities(),
                        'keyId'    => 'facility_entity_id',
                        'keyName'  => 'facility_name',
                        'data'     => 'organization_entity_id',
                        'dataName' => 'organizationId',
                        'none'     => 'Select a facility..',
                    ])

                    @include('modules.crm.ClientVisit.new-facility')


                    <hr/>
                    <div class="row"><div class="col-md-3 pull-left"><h3>Contact Person</h3></div></div>


                    @include('commons.select', [
                        'label'    => 'Contact Person' ,
                        'name'     => 'contact_entity_id',
                        'options'  => $client->contacts(),
                        'keyId'    => 'contact_entity_id',
                        'keyName'  => 'contact_name',
                        'data'     => 'organization_entity_id',
                        'dataName' => 'organizationId',
                        'none'     => 'Select a contact..',
                    ])

                    @include('modules.crm.ClientVisit.new-contact')


                    <hr/>
                    <div class="row"><div class="col-md-3 pull-left"><h3>Visit</h3></div></div>

                    @include('commons.select', [
                        'label'   => 'Agent Organization' ,
                        'name'    => 'agent_organization_entity_id',
                        'options' => $client->agentOrganizations(),
                        'keyId'   => 'organization_entity_id',
                        'keyName' => 'organization_name',
                    ])

                    @include('commons.select', [
                        'label'    => 'Agent' ,
                        'name'     => 'agent_entity_id',
                        'options'  => $client->agents(),
                        'keyId'    => 'individual_entity_id',
                        'keyName'  => 'agent_name',
                        'data'     => 'organization_entity_id',
                        'dataName' => 'organizationId',
                        'none'     => 'Select an agent..',
                    ])

                    <div class="row">
                        <div class="col-md-6">
                            @include('commons.select', [
                                'label'   => 'Client Status' ,
                                'name'    => 'client_status_id',
                                'options' => $client->statuses(),
                                'keyId'   => 'client_status_id',
                                'keyName' => 'client_status',
                            ])
                        </div>
                        <div class="col-md-6">
                            @include('commons.select', [
                                'label'   => 'Product' ,
                                'name'    => 'product_entity_id',
                                'options' => $client->products(),
                                'keyId'   => 'product_entity_id',
                                'keyName' => 'product',
                            ])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            @include('commons.select', [
                                'label'   => 'Unit Type' ,
                                'name'    => 'unit_type_id',
                                'options' => $client->unitTypes(),
                                'keyId'   => 'unit_type_id',
                                'keyName' => 'unit_type',
                            ])
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="expected_units">Expected Units</label>
                                <div class="col-md-8">
                                    <input id="expected_units" class="form-control" type="text" name="expected_units" value="{{ v('expected_units') }}" placeholder="Expected Units">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="commited_price">Commited Price</label>
                        <div class="col-md-8">
                            <input id="commited_price" class="form-control" type="text" name="commited_price" value="{{ v('commited_price') }}" placeholder="Commited Price">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
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
                        </div>
                        <div class="col-md-6">
                            @include('commons.select', [
                                'label'   => 'Visit Type' ,
                                'name'    => 'visit_type_id',
                                'options' => $client->visitType(),
                                'keyId'   => 'visit_type_id',
                                'keyName' => 'visit_type',
                            ])
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
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
                        </div>
                        <div class="col-md-6">
                            @include('commons.select', [
                                'label'   => 'Next Visit Type' ,
                                'name'    => 'next_visit_type_id',
                                'options' => $client->visitType(),
                                'keyId'   => 'visit_type_id',
                                'keyName' => 'visit_type',
                            ])
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

        filterSelect({
            firstId: '#organization_entity_id',
            firstFilter: 'value',
            secondId: '#facility_entity_id',
            secondFilter: 'data-organizationId'
        });

        filterSelect({
            firstId: '#organization_entity_id',
            firstFilter: 'value',
            secondId: '#contact_entity_id',
            secondFilter: 'data-organizationId'
        });

        filterSelect({
            firstId: '#agent_organization_entity_id',
            firstFilter: 'value',
            secondId: '#agent_entity_id',
            secondFilter: 'data-organizationId'
        });

        $('.new-checkbox').change(function() {
            var selectId = '#' + $(this).attr('data-selectid');
            if($(this).is(":checked")) {
                $(this).closest('.new-checkbox-group').find('.new-checkbox-inputs').fadeIn();
                $(selectId + ' option[value="none"]').prop('selected', true)
                $(selectId).prop('disabled', true);
            } else {
                $(this).closest('.new-checkbox-group').find('.new-checkbox-inputs').fadeOut();
                $(selectId).prop('disabled', false);
            }
        });

        $('#facility_new').change(function() {
            if($(this).is(":checked")) {
                copyOrganizationInfoToFacility();
            }
        });

        function copyOrganizationInfoToFacility() {
            if (!$('#organization_new').is(':checked')) {
                return false;
            }
            if (!$('#copy_org_contact').is(':checked')) {
                return false;
            }
            var orgAddress1 = $('#organization_address1').val();
            var orgAddress2 = $('#organization_address2').val();
            var orgCityId = $('#organization_city_id option:selected').val();
            var orgCityAreaNew = $('#organization_city_area_new').val();
            var orgWorkPhone = $('#organization_work_phone').val();
            var orgMobilePhone = $('#organization_mobile_phone').val();

            $('#facility_address1').val(orgAddress1);
            $('#facility_address2').val(orgAddress2);

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

            $('#facility_work_phone').val(orgWorkPhone);
            $('#facility_mobile_phone').val(orgMobilePhone);
        }

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
