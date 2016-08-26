@extends('layout.cabinet')

@section('title', 'Inbox')
@section('screen-name', 'mobile-grid-screen inbox-detail-screen')

@section('content')

<?php
    $message = $inbox->messageDetail();
?>

<div id="mobile-panel" class="panel-group">
    <section class="panel">
        <header class="panel-heading">
            <h3 class="panel-header-text">Inbox - Detail</h3>
        </header>
        <div class="panel-body">

            <div class="inbox-list">
                <div class="inbox-row header-row">
                    <div class="message-date">Received Date</div>
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

            @if ($inbox->userCanSendMessage())

            <button class="btn btn-primary reply-toggle" type="submit"><i class="fa fa-reply" aria-hidden="true"></i> Reply</button>

            <form id="inbox-form" class="" style="" action="/cabinet/inbox/new" method="POST">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-md-12 compose-buttons">
                        <span class="compose-text">Reply</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 subject-field">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <label class="btn">Subject:</label>
                            </span>
                            <input type="text" name="email_subject" class="subject-input form-control" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 message-field">
                        <textarea rows="5" name="email_text" class="message-input form-control" placeholder=""></textarea>
                    </div>
                </div>

                <input type="hidden" name="parent_email_id" value="{{$message['email_id']}}" id="parent_email_id">

                <div class="row">
                    <div class="col-md-12 send-button-col">
                        <button class="btn btn-primary pull-right send-btn" type="submit">Send</button>
                    </div>
                </div>

            </form>
            @endif

        </div>
    </section>
</div>

@endsection

@section('scripts')
<script type="text/javascript">

    $('.reply-toggle').on('click', function() {
        $(this).remove();
        $('#inbox-form').show();
    });

</script>
@endsection
