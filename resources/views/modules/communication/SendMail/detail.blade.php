@extends('layout.cabinet')

@section('title', 'Send Mail - Detail')
@section('screen-name', 'mobile-grid-screen inbox-detail-screen')

@section('content')

<?php
    $message = $inbox->messageDetail();
?>

<div id="mobile-panel" class="panel-group">
    <section class="panel">
        <header class="panel-heading">
            <h3 class="panel-header-text">Send Mail - Detail</h3>
        </header>
        <div class="panel-body">

            <div class="inbox-list">
                <div class="inbox-row header-row">
                    <div class="message-date">Send Date</div>
                </div>
                <div data-emailId="{{$message['email_id']}}" class="inbox-row">
                    <div class="grid-sender">From: {{$message['sender_name']}}</div>
                    <div class="grid-subject">To: {{$message['to_list']}}</div>
                    <div class="grid-subject">Subject: {{$message['email_subject']}}</div>
                    <div class="message-date">{!!mobile_date($message['email_send_datetime'])!!}</div>
                </div>
            </div>

            <div class="email-text">
                {{$message['email_text']}}
            </div>

        </div>
    </section>
</div>

@endsection

