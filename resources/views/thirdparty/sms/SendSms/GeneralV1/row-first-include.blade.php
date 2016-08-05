<td class="text-center">
    @if (!isset($row['mobile_phone']) || !isset($row['account_entity_id']))
        <input disabled="disabled" type="checkbox" data-id="" class="account-entity-id" name="account_entity_id" value="">

    @elseif (empty($row['mobile_phone']))
        <input disabled="disabled" type="checkbox" data-id="{{$row['account_entity_id']}}" class="account-entity-id" name="account_entity_id" value="">

    @else
        <input type="checkbox" data-id="{{$row['account_entity_id']}}" class="account-entity-id" name="account_entity_id" value="{{$row['account_entity_id']}}">
    @endif
</td>

