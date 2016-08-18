<?php $logo = storage_path('uploads/'.domain().'/school-logo/logo.png'); ?>
@if (Device::isAndroidMobile())
    @if (file_exists($logo))
        <img src="/cabinet/img/school-logo/logo.png" alt="School Image" class="school-logo text-right">
    @else
        <img src="/images/school-logo.png" alt="School Image" class="school-logo text-right">
    @endif
@else
    @if (file_exists($logo))
        <img src="{{$logo}}" alt="School Image" class="school-logo text-right">
    @else
        <img src="{{storage_path('pdf/school-logo.png')}}" alt="School Image" class="school-logo text-right">
    @endif
@endif
