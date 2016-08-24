<?php
    $messages = $inbox->messages();
?>

<div class="inbox-row header-row">
    <div class="message-date">Exam Date</div>
</div>
@foreach ($messages as $message)
    <div class="inbox-row">
        <div class="grid-sender">{{$message['exam']}} ({{$message['subject']}})</div>
        <div class="grid-subject">{{$message['student_full_name']}} ({{$message['class_name']}})</div>
        <div class="message-date"><br/>{{style_date($message['exam_date'])}}</div>
        <div class="grid-text">Exam Time: {{$message['exam_start_time']}} to {{$message['exam_end_time']}}</div>
    </div>
@endforeach

@if (count($messages) == 0 && $inbox->getPageNr() == 0)
    <div class="no-rows-message">There are no rows.</div>
@endif

@if (count($messages) && count($messages) >= $inbox->batchSize())
    @if (!is_null($inbox->q))
        <a href="/cabinet/my-exam-schedule?page={{$inbox->nextPageNr()}}&r={{$inbox->rowsPerPage()}}&q={{$inbox->searchQuery()}}">More</a>
    @else
        <a href="/cabinet/my-exam-schedule?page={{$inbox->nextPageNr()}}&r={{$inbox->rowsPerPage()}}">More</a>
    @endif
@endif
