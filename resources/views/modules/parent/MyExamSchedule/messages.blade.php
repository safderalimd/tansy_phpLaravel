<?php
    $messages = $inbox->messages();
?>
@foreach ($messages as $message)
    <div class="inbox-row">
        <div class="grid-sender">Subject: {{$message['subject']}}</div>
        <div class="grid-subject">Student: {{$message['student_full_name']}}</div>
        <div class="grid-subject">Exam: {{$message['exam']}}</div>
        <div class="grid-subject">Class: {{$message['class_name']}}</div>
        <div class="message-date">Exam Date: <br/>{{style_date($message['exam_date'])}}</div>
        <div class="grid-subject">Exam Start Time: {{$message['exam_start_time']}}</div>
        <div class="grid-subject">Exam End Time: {{$message['exam_end_time']}}</div>
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
