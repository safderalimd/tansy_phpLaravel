@if (session()->has('flash_notification.message'))
    <div class="flash-message">
        <i class="material-icons">speaker_notes</i> {!! session('flash_notification.message') !!}
    </div>
@endif
