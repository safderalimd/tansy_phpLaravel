<?php
    $messages = $inbox->messages();
?>

<div class="inbox-row inbox-header-row">
    <div class="message-date">SEND DATE</div>
    <div class="from-header">SEND TO</div>
</div>
@foreach ($messages as $message)
    <div onclick="openDetail(this, event)" data-emailId="{{$message['email_id']}}" class="inbox-row @if($message['email_read_flag'] == 0) unread @endif">
        <div class="select-circle" onclick="openDetail(this, event)">
            <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
        </div>
        <div class="message-sender">{{$message['send_to_name']}}</div>
        <div class="message-subject">{{$message['email_subject']}}</div>
        <div class="message-date">{!!mobile_date($message['email_send_datetime'])!!}</div>
        <div class="details-arrow">
            <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
        </div>
    </div>
@endforeach

@if (count($messages) == 0 && $inbox->getPageNr() == 0)
    <div class="no-rows-message">There are no messages.</div>
@endif

@if (count($messages) && count($messages) >= $inbox->batchSize())
    @if (!is_null($inbox->q))
        <a href="/cabinet/send-mail?page={{$inbox->nextPageNr()}}&r={{$inbox->rowsPerPage()}}&q={{$inbox->searchQuery()}}">More</a>
    @else
        <a href="/cabinet/send-mail?page={{$inbox->nextPageNr()}}&r={{$inbox->rowsPerPage()}}">More</a>
    @endif
@endif
