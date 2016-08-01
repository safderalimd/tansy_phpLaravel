@extends('layout.cabinet')

@section('title', 'Inbox')

@section('content')

<?php
    $messages = $inbox->messages();
    $totalMessages = $inbox->totalMessages();
?>

<div class="panel-group">
    <div class="panel">

        <div class="row">
            <div class="col-md-12">
                <section class="panel">

                    <header class="panel-heading">
                        <h3 class="panel-header-text">Inbox</h3>
                        <form action="/cabinet/inbox" class="pull-right" method="POST">
                            <div class="search-box">
                                <button class="search-submit" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                <input type="text" class="search-input form-control" placeholder="Search">
                            </div>
                        </form>
                    </header>

                    <div class="panel-body">

                        <div class="table-inbox-wrap">
                            <table class="table table-inbox table-hover">
                                <tr class="unread">
                                    <td class="select-circle">
                                        <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                                    </td>
                                    <td>Google Inc.</td>
                                    <td>Your new account is ready.</td>
                                    <td class="text-right">08:10 AM</td>
                                </tr>
                                <tr class="unread">
                                    <td class="select-circle">
                                        <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                                    </td>
                                    <td>Mark Thompson</td>
                                    <td>Last project updates</td>
                                    <td class="text-right">March 15</td>
                                </tr>
                                <tr class="unread">
                                    <td class="select-circle">
                                        <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                                    </td>
                                    <td>Wonder Corp.</td>
                                    <td>Thanks for your registration</td>
                                    <td class="text-right">March 15</td>
                                </tr>
                                <tr class="">
                                    <td class="select-circle">
                                        <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                                    </td>
                                    <td>Facebook</td>
                                    <td>New Friendship Request</td>
                                    <td class="text-right">March 13</td>
                                </tr>
                                <tr class="">
                                    <td class="select-circle">
                                        <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                                    </td>
                                    <td>Mark Webber</td>
                                    <td>The server is down</td>
                                    <td class="text-right">March 09</td>
                                </tr>
                                <tr class="">
                                    <td class="select-circle">
                                        <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                                    </td>
                                    <td>Facebook</td>
                                    <td>New message from Patrick S.</td>
                                    <td class="text-right">March 08</td>
                                </tr>
                                <tr class="">
                                    <td class="select-circle">
                                        <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                                    </td>
                                    <td>Paypal inc.</td>
                                    <td>New payment received</td>
                                    <td class="text-right">March 04</td>
                                </tr>
                                <tr class="">
                                    <td class="select-circle">
                                        <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                                    </td>
                                    <td>Andrea</td>
                                    <td class="view-message view-message">Weekend plans</td>
                                    <td class="text-right">March 04</td>
                                </tr>
                                <tr class="">
                                    <td class="select-circle">
                                        <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                                    </td>
                                    <td>David Green</td>
                                    <td class="view-message view-message">Soccer tickets</td>
                                    <td class="text-right">February 22</td>
                                </tr>
                                <tr class="">
                                    <td class="select-circle">
                                        <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                                    </td>
                                    <td>Evelyn</td>
                                    <td class="view-message view-message">Surprise party</td>
                                    <td class="text-right">February 19</td>
                                </tr>
                                <tr class="">
                                    <td class="select-circle">
                                        <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                                    </td>
                                    <td>Martin Moore</td>
                                    <td>Hey mate!</td>
                                    <td class="text-right">February 17</td>
                                </tr>
                                <tr class="">
                                    <td class="select-circle">
                                        <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                                    </td>
                                    <td class="dont-show">Facebook</td>
                                    <td>Paul published on your wall</td>
                                    <td class="text-right">February 14</td>
                                </tr>
                                <tr class="">
                                    <td class="select-circle">
                                        <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                                    </td>
                                    <td>Steve Stoll</td>
                                    <td>Update developed</td>
                                    <td class="text-right">February 11</td>
                                </tr>
                                <tr class="">
                                    <td class="select-circle">
                                        <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                                    </td>
                                    <td class="dont-show">Laura Anton</td>
                                    <td class="view-message view-message">New subscription</td>
                                    <td class="text-right">January 14</td>
                                </tr>
                                <tr class="">
                                    <td class="select-circle">
                                        <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                                    </td>
                                    <td>Ryanair</td>
                                    <td>Your flight tickets</td>
                                    <td class="text-right">January 07</td>
                                </tr>
                                <tr class="">
                                    <td class="select-circle">
                                        <span><i class="fa fa-circle-thin" aria-hidden="true"></i></span>
                                    </td>
                                    <td>Twitter</td>
                                    <td>Password reset</td>
                                    <td class="text-right">January 04</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>


    </div>
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
