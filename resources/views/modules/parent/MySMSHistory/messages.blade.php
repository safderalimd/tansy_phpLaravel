<?php
    $messages = $inbox->messages();
?>

<div class="inbox-row header-row">
    <div class="message-date">SMS Send Date</div>
</div>
@foreach ($messages as $message)
    <div class="inbox-row">
        <div class="grid-sender">{{$message['student_full_name']}} ({{$message['class_name']}})</div>
        <div class="grid-subject">{{$message['sms_type']}}</div>
        <div class="message-date">{!!mobile_date($message['sms_send_date_time'])!!}</div>
        <div class="grid-text">{{$message['sms_message']}}</div>
    </div>
@endforeach

@if (count($messages) == 0 && $inbox->getPageNr() == 0)
    <div class="no-rows-message">There are no SMS messages.</div>
@endif

@if (count($messages) && count($messages) >= $inbox->batchSize())
    @if (!is_null($inbox->q))
        <a href="/cabinet/my-sms-history?page={{$inbox->nextPageNr()}}&r={{$inbox->rowsPerPage()}}&q={{$inbox->searchQuery()}}">More</a>
    @else
        <a href="/cabinet/my-sms-history?page={{$inbox->nextPageNr()}}&r={{$inbox->rowsPerPage()}}">More</a>
    @endif
@endif
