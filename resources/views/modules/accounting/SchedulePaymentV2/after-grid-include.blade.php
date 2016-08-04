</form>

<div class="row">
<div class="col-md-6 col-md-offset-6">

    <form class="form-horizontal" id="schedule-payment-v2-form" action="{{form_action_full()}}" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="actEID_schAmnt_list" id="row_ids" value="">

        <div class="form-group">
            <label class="col-md-6 control-label" for="product_entity_id">Product</label>
            <div class="col-md-6">
                <select id="product_entity_id" class="form-control" name="product_entity_id">
                    <option value="none">Select a product..</option>
                    @foreach($grid->paymentType() as $option)
                        <option value="{{ $option['payment_type_id'] }}">{{ $option['payment_type'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-6 control-label" for="start_date">Start Date</label>
            <div class="col-md-6">
                <div class="input-group date">
                    <input id="start_date" class="form-control" type="text" name="start_date" value="{{ v('start_date') }}" placeholder="Start Date">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"><span
                                    class="glyphicon glyphicon-calendar"></span></button>
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group">
           <div class="col-md-12">
                <a href="{{ url("/cabinet/schedule-payment-v2")}}" class="pull-right btn btn-default cancle_btn">Cancel</a>
                <button id="schedule-btn" type="submit" class="pull-right btn btn-primary" style="margin-right: 10px;">Schedule Payments</button>
            </div>
        </div>
    </form>

</div>
</div>
