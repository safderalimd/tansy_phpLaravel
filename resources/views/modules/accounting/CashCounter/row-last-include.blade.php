<td class="text-center">
    @if (isset($row['collection_amount']) && isset($row['date_id']))
        <input type="checkbox" checked="checked" class="cache-row-id" name="cache_row_id" value="{{$row['collection_amount']}}" data-dateid="{{$row['date_id']}}">
    @else
        <input type="checkbox" disabled="disabled" class="cache-row-id" name="cache_row_id" value="" data-dateid="">
    @endif
</td>
