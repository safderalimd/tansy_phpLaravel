@extends('layout.cabinet')

@section('title', 'My Attendance')
@section('screen-name', 'mobile-grid-screen parents-grid')

@section('content')

<div id="mobile-panel" class="panel-group">
    <section class="panel">

        <header class="panel-heading">
            <h3 class="panel-header-text">My Attendance</h3>
        </header>

        <div class="panel-body">
            <div class="inbox-list">

                @include('modules.parent.MyAttendance.messages')

            </div>
        </div>
    </section>
</div>

@endsection

@section('scripts')
<script type="text/javascript">

    $('.inbox-list').jscroll({
        loadingHtml: '<div class="preloader-scroll"><i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Loading...</span></div>'
    });

</script>
@endsection
