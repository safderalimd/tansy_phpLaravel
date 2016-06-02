<div class="new-checkbox-group">
    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            <div class="checkbox">
                <label style="padding-left:20px;">
                    <input data-selectid="contact_entity_id" name="contact_new" class="new-checkbox" type="checkbox"> New
                </label>
            </div>
        </div>
    </div>

    <div class="new-checkbox-inputs" style="display:none;">

        <div class="form-group">
            <label class="col-md-4 control-label" for="organization_contact_frist_name">First Name</label>
            <div class="col-md-8">
                <input id="organization_contact_frist_name" class="form-control" type="text" name="organization_contact_frist_name" value="{{ v('organization_contact_frist_name') }}" placeholder="First Name">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="organization_contact_last_name">Last Name</label>
            <div class="col-md-8">
                <input id="organization_contact_last_name" class="form-control" type="text" name="organization_contact_last_name" value="{{ v('organization_contact_last_name') }}" placeholder="Last Name">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="organization_contact_email">Email</label>
            <div class="col-md-8">
                <input id="organization_contact_email" class="form-control" type="email" name="organization_contact_email" value="{{ v('organization_contact_email') }}" placeholder="Email">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="organization_contact_work_phone">Phone Number</label>
            <div class="col-md-8">
                <input id="organization_contact_work_phone" class="form-control" type="text" name="organization_contact_work_phone" value="{{ v('organization_contact_work_phone') }}" placeholder="Phone Number">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="organization_contact_mobile_phone">Mobile Number</label>
            <div class="col-md-8">
                <input id="organization_contact_mobile_phone" class="form-control" type="text" name="organization_contact_mobile_phone" value="{{ v('organization_contact_mobile_phone') }}" placeholder="Mobile Number">
            </div>
        </div>

    </div>
</div>
