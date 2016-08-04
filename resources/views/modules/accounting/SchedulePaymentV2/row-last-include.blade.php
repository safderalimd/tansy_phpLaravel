<td class="text-center">
    @if (isset($row['collection_amount']) && isset($row['date_id']) && isset($row['balance_amount']) && isset($row['payment_type_id']))
        <input type="checkbox" data-paymentTypeId="{{$row['payment_type_id']}}" checked="checked" class="payment-row-id" name="cache_row_id" value="{{$row['collection_amount']}}" @if (isset($row['payment_type'])) data-paymentType="{{$row['payment_type']}}" @endif data-balanceAmount="{{$row['balance_amount']}}" data-dateid="{{$row['date_id']}}">
    @else
        <input type="checkbox" disabled="disabled" class="payment-row-id" name="cache_row_id" value="" data-dateid="">
    @endif
</td>
