<div class="row">
    <div class="col-md-4 logo-container">
        @include('reports.common.pdf-logo-img')
    </div>
    <div class="col-md-4 school-container">
        <h3 class="school-name text-center">{{$school}}</h3>
        <h4 class="school-phone text-center">Phone No. {{phone_number_spaces($phone)}}</h4>
    </div>
</div>

