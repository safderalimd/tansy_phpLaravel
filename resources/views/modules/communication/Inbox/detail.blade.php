@extends('layout.cabinet')

@section('title', 'Inbox')
@section('screen-name', 'mobile-grid-screen')

@section('content')

<?php

    $message = $inbox->detail();

?>

<div id="mobile-panel" class="panel-group">
    <section class="panel">
        <header class="panel-heading">
            <h3 class="panel-header-text">Inbox - Detail</h3>
        </header>
        <div class="panel-body">

            <div class="divider-line"></div>
            <div class="inbox-list">
                <div data-emailId="{{$message['email_id']}}" class="inbox-row @if($message['email_read_flag'] == 0) unread @endif">
                    <div class="select-circle">
                        <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                    </div>
                    <div class="message-sender">{{$message['sender_name']}}</div>
                    <div class="message-subject">{{$message['email_subject']}}</div>
                    <div class="message-date">{{style_date($message['email_send_datetime'])}}</div>
                    <div class="details-arrow">
                        <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

@endsection

@section('scripts')
<script type="text/javascript">



</script>
@endsection
