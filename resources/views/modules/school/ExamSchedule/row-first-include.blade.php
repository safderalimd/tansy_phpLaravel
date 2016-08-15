<td class="text-center">
    @if (isset($row['class_entity_id']) && isset($row['subject_entity_id']))
        <input type="checkbox" data-classEntityId="{{$row['class_entity_id']}}" data-subjectEntityId="{{$row['subject_entity_id']}}" class="subject-entity-id" name="subject_id" value="{{$row['subject_entity_id']}}">
    @else
        <input disabled="disabled" type="checkbox" data-classEntityId="" data-subjectEntityId="" class="subject-entity-id" name="subject_id" value="">
    @endif
</td>
