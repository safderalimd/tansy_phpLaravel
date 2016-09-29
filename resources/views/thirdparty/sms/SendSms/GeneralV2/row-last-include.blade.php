<td>
    @if (!isset($row['mobile_phone']) || !isset($row['account_entity_id']))
        <textarea disabled="disabled" style="width:100%;" rows="2" maxlength="275" name="" class="custom-message-text form-control"></textarea>

    @elseif (empty($row['mobile_phone']))
        <textarea disabled="disabled" style="width:100%;" rows="2" maxlength="275" name="" class="custom-message-text form-control"></textarea>

    @else
        <textarea style="width:100%;" rows="2" maxlength="275" name="" class="custom-message-text form-control"></textarea>

    @endif
</td>
