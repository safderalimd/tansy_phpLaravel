<?php
    if (!isset($amountIndex)) {
        $amountIndex = 0;
    }
    $amountIndex++;
?>
<td style="width:178px;">
    <input data-rule-number="true" data-rule-min="0" class="input-amount-value form-control" type="text" name="amount{{$amountIndex}}" value="">
</td>
<td class="text-center">
    @if (isset($row['student_entity_id']))
        <input type="checkbox" class="payment-row-id" name="payment_row_id" value="{{$row['student_entity_id']}}">
    @else
        <input type="checkbox" disabled="disabled" class="payment-row-id" name="payment_row_id" value="">
    @endif
</td>
