<td>
    @if (isset($row['exam_schedule_id']) && !is_null($row['exam_schedule_id']))
        <a class="btn btn-default" href="{{url("/cabinet/exam-schedule/edit/{$row['exam_schedule_id']}")}}" title="Edit">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        </a>
        <a class="btn btn-default formConfirm" href="{{url("/cabinet/exam-schedule/delete?esi={$row['exam_schedule_id']}")}}"
           title="Delete"
           data-title="Delete Exam Schedule"
           data-message="Are you sure to delete the selected record?"
        >
            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
        </a>

    @else
        <a class="btn btn-default" href="" disabled="disabled" title="Edit">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        </a>
        <a class="btn btn-default" disabled="disabled" href="#"
           title="Delete"
           data-title="Delete Exam Schedule"
           data-message="Are you sure to delete the selected record?"
        >
            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
        </a>
    @endif

    @if (isset($row['paper_name']) && $row['paper_name'] == 'Paper 1')
        @if (isset($row['exam_schedule_id']) && !is_null($row['exam_schedule_id']))
            <a class="btn btn-default" href="{{url("/cabinet/exam-schedule/paper-2/{$row['exam_schedule_id']}")}}" title="Create Paper 2">Create Paper 2</a>
        @else
            <a class="btn btn-default" href="#" disabled="disabled" title="Create Paper 2">Create Paper 2</a>
        @endif
    @endif
</td>
