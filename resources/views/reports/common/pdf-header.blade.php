<div class="row">
    <div class="col-md-4 logo-container">
        @if (Device::isAndroidMobile())
            <img src="/cabinet/img/school-logo/logo.png" alt="School Image" class="school-logo text-right">
        @else
            <?php $logo = storage_path('uploads/'.domain().'/school-logo/logo.png'); ?>
            @if (file_exists($logo))
                <img src="{{$logo}}" alt="School Image" class="school-logo text-right">
            @else
                <img src="{{storage_path('pdf/school-logo.png')}}" alt="School Image" class="school-logo text-right">
            @endif
        @endif
    </div>
    <div class="col-md-4 school-container">
        <h3 class="school-name text-center">{{$school}}</h3>
        <h4 class="school-phone text-center">Phone No. {{phone_number_spaces($phone)}}</h4>
    </div>
</div>

