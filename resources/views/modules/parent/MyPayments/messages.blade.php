<?php
    $messages = $inbox->messages();
?>

@foreach ($messages as $message)
    <div class="inbox-row">
        <div class="grid-sender">{{$message['student_full_name']}}</div>
        <div class="grid-subject">Receipt Number: {{$message['receipt_number']}}</div>
        <div class="grid-subject">Receipt Amount: &#x20b9; {{amount($message['receipt_amount'])}})</div>
        <div class="grid-subject">New Balance: &#x20b9; {{amount($message['new_balance'])}})</div>
        <div class="grid-subject">Financial Year Balance: &#x20b9; {{amount($message['financial_year_balance'])}})</div>
        <div class="message-date">{!!mobile_date($message['receipt_date'])!!}</div>
        <div class="grid-text">Schedule Name: {{$message['schedule_name']}}</div>
    </div>
@endforeach

@if (count($messages) == 0 && $inbox->getPageNr() == 0)
    <div class="no-rows-message">There are no rows.</div>
@endif

@if (count($messages) && count($messages) >= $inbox->batchSize())
    @if (!is_null($inbox->q))
        <a href="/cabinet/my-payments?page={{$inbox->nextPageNr()}}&r={{$inbox->rowsPerPage()}}&q={{$inbox->searchQuery()}}">More</a>
    @else
        <a href="/cabinet/my-payments?page={{$inbox->nextPageNr()}}&r={{$inbox->rowsPerPage()}}">More</a>
    @endif
@endif
