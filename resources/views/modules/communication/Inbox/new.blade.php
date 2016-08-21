@extends('layout.cabinet')

@section('title', 'Inbox')
@section('screen-name', 'mobile-grid-screen inbox-compose')

@section('content')

<div id="mobile-panel" class="panel-group">
    <section class="panel">

        <header class="panel-heading">
            <h3 class="panel-header-text">Inbox - Compose</h3>
        </header>


        <div class="panel-body">

            <div class="row">
                <div class="col-md-12 compose-buttons">
                    <a href="{{url("/cabinet/inbox")}}" class="close-btn btn btn-default pull-left">Cancel</a>
                    <span class="compose-text">Compose</span>
                    <button class="btn btn-primary pull-right send-btn" type="submit">Send</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 to-field">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <label class="btn">To:</label>
                        </span>
                        <button class="btn btn-default pull-right" type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 subject-field">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <label class="btn">Subject:</label>
                        </span>
                        <input type="text" class="subject-input form-control" placeholder="">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 message-field">
                    <textarea rows="5" class="message-input form-control" placeholder=""></textarea>
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
