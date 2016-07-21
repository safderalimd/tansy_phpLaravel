<td class="text-center">
    @if (isset($row['admission_id']))
        <input type="checkbox" class="admission-id" name="admission_id" value="{{$row['admission_id']}}">
    @else
        <input type="checkbox" disabled="disabled" class="admission-id" name="admission_id" value="">
    @endif
</td>
