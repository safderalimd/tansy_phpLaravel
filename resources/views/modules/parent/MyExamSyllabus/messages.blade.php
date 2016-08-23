<?php
    $messages = $inbox->messages();
?>

@foreach ($messages as $message)
    <div class="inbox-row">
        <div class="grid-sender">{{$message['subject']}}</div>
        <div class="grid-subject">{{$message['exam']}}</div>
        <div class="grid-subject">{{$message['class_name']}}</div>
        <div class="grid-subject">{{$message['student_full_name']}}</div>
        <div class="message-date">{!!mobile_date($message['exam_date'])!!}</div>
        <div class="grid-text">{{$message['syllabus']}}</div>
    </div>
@endforeach

@if (count($messages) == 0 && $inbox->getPageNr() == 0)
    <div class="no-rows-message">There are no rows.</div>
@endif

@if (count($messages) && count($messages) >= $inbox->batchSize())
    @if (!is_null($inbox->q))
        <a href="/cabinet/my-exam-syllabus?page={{$inbox->nextPageNr()}}&r={{$inbox->rowsPerPage()}}&q={{$inbox->searchQuery()}}">More</a>
    @else
        <a href="/cabinet/my-exam-syllabus?page={{$inbox->nextPageNr()}}&r={{$inbox->rowsPerPage()}}">More</a>
    @endif
@endif
