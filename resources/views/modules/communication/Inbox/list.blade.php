@extends('layout.cabinet')

@section('title', 'Inbox')
@section('screen-name', 'mobile-grid-screen')

@section('content')

<?php
    $messages = $inbox->messages();
    $totalMessages = $inbox->totalMessages();
?>

<div id="inbox-panel" class="panel-group">
    <section class="panel">

        <header class="panel-heading">
            <h3 class="panel-header-text">Inbox</h3>
        </header>

        <div class="panel-body">

            <div class="divider-line"></div>
            <form action="/cabinet/inbox" class="form-inline" method="POST">
                <div class="search-box">
                    <button class="search-submit" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                    <input type="text" class="search-input form-control" placeholder="Search">
                </div>
            </form>

            <div class="inbox-list">

                    <div class="inbox-row unread">
                        <div class="select-circle">
                            <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                        </div>
                        <div class="message-sender">Google Inc.</div>
                        <div class="message-subject">Your new account is ready.</div>
                        <div class="message-date">08:10 AM</div>
                        <div class="details-arrow">
                            <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <div class="inbox-row unread">
                        <div class="select-circle">
                            <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                        </div>
                        <div class="message-sender">Mark Thompson Extra Long text Extra Long text</div>
                        <div class="message-subject">Last project updates Extra Long text Extra Long text Extra Long text Extra Long text Extra Long text Extra Long text</div>
                        <div class="message-date">March 15</div>
                        <div class="details-arrow">
                            <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <div class="inbox-row unread">
                        <div class="select-circle">
                            <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                        </div>
                        <div class="message-sender">Wonder Corp.</div>
                        <div class="message-subject">Thanks for your registration</div>
                        <div class="message-date">March 15</div>
                        <div class="details-arrow">
                            <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <div class="inbox-row">
                        <div class="select-circle">
                            <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                        </div>
                        <div class="message-sender">Facebook</div>
                        <div class="message-subject">New Friendship Request</div>
                        <div class="message-date">March 13</div>
                        <div class="details-arrow">
                            <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <div class="inbox-row">
                        <div class="select-circle">
                            <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                        </div>
                        <div class="message-sender">Mark Webber</div>
                        <div class="message-subject">The server is down</div>
                        <div class="message-date">March 09</div>
                        <div class="details-arrow">
                            <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <div class="inbox-row">
                        <div class="select-circle">
                            <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                        </div>
                        <div class="message-sender">Facebook</div>
                        <div class="message-subject">New message from Patrick S.</div>
                        <div class="message-date">March 08</div>
                        <div class="details-arrow">
                            <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <div class="inbox-row">
                        <div class="select-circle">
                            <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                        </div>
                        <div class="message-sender">Paypal inc.</div>
                        <div class="message-subject">New payment received</div>
                        <div class="message-date">March 04</div>
                        <div class="details-arrow">
                            <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <div class="inbox-row">
                        <div class="select-circle">
                            <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                        </div>
                        <div class="message-sender">Andrea</div>
                        <div class="message-subject">Weekend plans</div>
                        <div class="message-date">March 04</div>
                        <div class="details-arrow">
                            <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <div class="inbox-row">
                        <div class="select-circle">
                            <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                        </div>
                        <div class="message-sender">David Green</div>
                        <div class="message-subject">Soccer tickets</div>
                        <div class="message-date">February 22</div>
                        <div class="details-arrow">
                            <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <div class="inbox-row">
                        <div class="select-circle">
                            <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                        </div>
                        <div class="message-sender">Evelyn</div>
                        <div class="message-subject">Surprise party</div>
                        <div class="message-date">February 19</div>
                        <div class="details-arrow">
                            <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <div class="inbox-row">
                        <div class="select-circle">
                            <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                        </div>
                        <div class="message-sender">Martin Moore</div>
                        <div class="message-subject">Hey mate!</div>
                        <div class="message-date">February 17</div>
                        <div class="details-arrow">
                            <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <div class="inbox-row">
                        <div class="select-circle">
                            <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                        </div>
                        <div class="message-sender">Facebook</div>
                        <div class="message-subject">Paul published on your wall</div>
                        <div class="message-date">February 14</div>
                        <div class="details-arrow">
                            <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <div class="inbox-row">
                        <div class="select-circle">
                            <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                        </div>
                        <div class="message-sender">Steve Stoll</div>
                        <div class="message-subject">Update developed</div>
                        <div class="message-date">February 11</div>
                        <div class="details-arrow">
                            <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <div class="inbox-row">
                        <div class="select-circle">
                            <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                        </div>
                        <div class="message-sender">Laura Anton</div>
                        <div class="message-subject">New subscription</div>
                        <div class="message-date">January 14</div>
                        <div class="details-arrow">
                            <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <div class="inbox-row">
                        <div class="select-circle">
                            <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                        </div>
                        <div class="message-sender">Ryanair</div>
                        <div class="message-subject">Your flight tickets</div>
                        <div class="message-date">January 07</div>
                        <div class="details-arrow">
                            <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <div class="inbox-row">
                        <div class="select-circle">
                            <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                        </div>
                        <div class="message-sender">Twitter</div>
                        <div class="message-subject">Password reset</div>
                        <div class="message-date">January 04</div>
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

    $('.select-circle span').on('click', function() {
        var icon = $('.fa', $(this));

        if (icon.hasClass('fa-circle')) {
            icon.removeClass('fa-circle').addClass('fa-circle-thin');
            icon.closest('tr').removeClass('selected');
        } else {
            icon.removeClass('fa-circle-thin').addClass('fa-circle');
            icon.closest('tr').addClass('selected');
        }
    });

</script>
@endsection
