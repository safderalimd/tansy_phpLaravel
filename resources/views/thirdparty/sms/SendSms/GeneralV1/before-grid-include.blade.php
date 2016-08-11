@include('commons.sms-inactive')

<form class="form-horizontal" action="" method="POST">
    <div class="form-group">
        <label class="col-xs-3 col-md-2 control-label" for="sms_type_id">SMS Type</label>
        <div class="col-xs-9 col-md-3">
            <select id="sms_type_id" class="form-control" name="sms_type_id">
                <option value="none">Select a sms type..</option>
                @foreach($sms->generalSmsTypes as $option)
                    <option {{ activeSelect($option['sms_type_id'], 'sti') }} value="{{ $option['sms_type_id'] }}">{{ $option['sms_type'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-xs-4 col-xs-offset-0 col-sm-10 col-md-3 col-md-offset-3">
            <h4 class="text-right">SMS Balance:</h4>
        </div>
        <div class="col-xs-5 col-sm-2 col-md-1">
            <h4 class="text-left"><strong id="sms-balance-count" data-balance="{{$sms->smsBalanceCount}}" >{{nr($sms->smsBalanceCount)}}</strong></h4>
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-3 col-md-2 control-label" for="sms_account_entity_id">Filter Accounts</label>
        <div class="col-xs-9 col-md-3">
            <select id="sms_account_entity_id" class="form-control" name="sms_account_entity_id">
                <option value="none">Select an account..</option>
                @foreach($sms->smsAccountTypes as $option)
                    <option data-rowType="{{$option['row_type']}}" {{activeSelectByTwo($option['entity_id'], $option['row_type'], 'aei', 'art')}} value="{{ $option['entity_id'] }}">{{ $option['drop_down_list_name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-xs-4 col-xs-offset-0 col-sm-10 col-md-3 col-md-offset-3">
            <h4 class="text-right">Current Selected:</h4>
        </div>
        <div class="col-xs-5 col-sm-2 col-md-1">
            <h4 class="text-left"><strong id="current-selected">0</strong></h4>
        </div>
    </div>
</form>


