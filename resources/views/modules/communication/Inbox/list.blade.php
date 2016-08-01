@extends('layout.cabinet')

@section('title', 'Inbox')

@section('content')

<?php
    $messages = $inbox->messages();
    $totalMessages = $inbox->totalMessages();
?>

inbox


@endsection
