<?php
    $messages = $inbox->messages();
?>

<div class="inbox-row header-row">
    <div class="message-date">Posting Date</div>
</div>
@foreach ($messages as $message)
    <div class="inbox-row">
        <div class="grid-sender">{{$message['student_full_name']}} ({{$message['class_name']}})</div>
        <div class="grid-subject">System Receipt Number: {{$message['receipt_number']}}</div>
        <div class="grid-subject">Manual Receipt Number: {{$message['manual_receipt_number']}}</div>
        <div class="grid-subject">Receipt Date: {{style_date($message['receipt_date'])}}</div>
        <div class="message-date">{!!mobile_date($message['posting_date_time'])!!}</div>
        <div class="grid-subject">Receipt Amount: &#x20b9; {{amount($message['receipt_amount'])}}</div>
        <div class="grid-subject">Financial Year Balance: &#x20b9; {{amount($message['financial_year_balance'])}}</div>
        <div class="grid-text">Product Name: {{$message['product_name']}}</div>
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
