@extends('layout.cabinet')

@section('title', 'My Time Table')
@section('screen-name', 'mobile-grid-screen parents-grid')

@section('content')

<div id="mobile-panel" class="panel-group">
    <section class="panel">

        <header class="panel-heading">
            <h3 class="panel-header-text">My Time Table</h3>
        </header>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ url("/cabinet/my-time-table?day=".($inbox->day - 86400))}}" class="btn btn-default btn-circle"><i class="glyphicon glyphicon-arrow-left"></i></a>
                    <span style="font-size:17px;" class="">{{$inbox->getDate()}} ({{$inbox->dayName()}})</span>
                    <a href="{{ url("/cabinet/my-time-table?day=".($inbox->day + 86400))}}" class="btn btn-default btn-circle"><i class="glyphicon glyphicon-arrow-right"></i></a>
                </div>
            </div>

            <div class="inbox-list">

                <?php
                    $messages = $inbox->messages();
                ?>


                <div class="inbox-row header-row">
                    <div class="message-date">Period</div>
                </div>
                @foreach ($messages as $message)
                    <?php
                        $subjectName = isset($message['subject_name']) ? $message['subject_name'] : '-';
                        $teacher = isset($message['teacher_name']) ? $message['teacher_name'] : '';
                        $periodName = isset($message['period_name']) ? $message['period_name'] : '';
                        $periodType = isset($message['period_type']) ? $message['period_type'] : '';
                    ?>
                    @if ($periodType != 'Break')
                        <div class="inbox-row">
                            <div class="grid-sender">{{$subjectName}}</div>
                            <div class="grid-subject">{{$teacher}}</div>
                            <div class="message-date">{{$periodName}}</div>
                        </div>
                    @endif
                @endforeach

                @if (count($messages) == 0)
                    <div class="no-rows-message">Timetable for this day is empty.</div>
                @endif

            </div>
        </div>
    </section>
</div>

@endsection
