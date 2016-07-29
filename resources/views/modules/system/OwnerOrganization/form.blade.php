@extends('layout.cabinet')

@section('title', 'My Organization - Edit')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th"></i>
                    <h3>My Organization - Edit</h3>
                </div>

                <div class="panel-body edit_form_wrapper">
                    <section class="form_panel">

                    @include('commons.errors')

                    <form id="my-organization-form" class="form-horizontal" accept-charset="UTF-8" action="{{ form_action() }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}

<hr/>
<div class="row"><div class="col-md-3 pull-left"><h3>Organization</h3></div></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="organization_name">Name</label>
                            <div class="col-md-8">
                                <input id="organization_name" class="form-control" type="text" name="organization_name" value="{{ v('organization_name') }}" placeholder="Name">
                            </div>
                        </div>

                        <?php $logo = storage_path('uploads/'.domain().'/school-logo/logo.png'); ?>
                        @if (file_exists($logo))
                            <div class="form-group">
                                <label class="col-md-4 control-label">Logo</label>
                                <div class="col-md-8">
                                    <img src="/cabinet/img/school-logo/logo.png?ri=<?php echo time().uniqid(); ?>" alt="Logo" class="img-thumbnail">
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <label class="col-md-4 control-label">Upload Logo</label>
                            <div class="col-md-8">
                                <label class="btn btn-default btn-file" style="padding-left:12px;">Choose File...{!! Form::file('attachment', array('class'=>'form-control')) !!}</label>
                                <span class="file-name"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="address1">Adress 1</label>
                            <div class="col-md-8">
                                <input id="address1" class="form-control" type="text" name="address1" value="{{ v('address1') }}" placeholder="Adress 1">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="address2">Adress 2</label>
                            <div class="col-md-8">
                                <input id="address2" class="form-control" type="text" name="address2" value="{{ v('address2') }}" placeholder="Adress 2">
                            </div>
                        </div>

                        @include('commons.select', [
                            'label'    => 'City',
                            'name'     => 'city_id',
                            'options'  => $organization->cities(),
                            'keyId'    => 'city_id',
                            'keyName'  => 'city_name',
                            'none'     => 'Select a city..',
                            'required' => true,
                        ])

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="city_area">City Area</label>
                            <div class="col-md-8">
                                <select autocomplete="off" id="city_area" class="form-control" name="city_area">
                                    <option></option>
                                    <?php
                                        $cityAreaValue = '';
                                    ?>
                                    @foreach($organization->cityAreas() as $option)
                                        <?php
                                            if (old('city_area') == $option['city_area']) {
                                                $cityAreaValue = $option['city_area'];
                                            }
                                        ?>
                                        <option {{ s('city_area', $option['city_area']) }} value="{{ $option['city_area'] }}">{{ $option['city_area'] }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" value="{{$cityAreaValue}}" name="city_area_new" id="city_area_new">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="work_phone">Work Phone</label>
                            <div class="col-md-8">
                                <input id="work_phone" class="form-control" type="text" name="work_phone" value="{{ v('work_phone') }}" placeholder="Work Phone">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="mobile_phone">Mobile Phone</label>
                            <div class="col-md-8">
                                <input id="mobile_phone" class="form-control" type="text" name="mobile_phone" value="{{ v('mobile_phone') }}" placeholder="Mobile Phone">
                            </div>
                        </div>

<hr/>
<div class="row"><div class="col-md-3 pull-left"><h3>Contact Person</h3></div></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="contact_first_name">First Name</label>
                            <div class="col-md-8">
                                <input id="contact_first_name" class="form-control" type="text" name="contact_first_name" value="{{ v('contact_first_name') }}" placeholder="First Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="contact_last_name">Last Name</label>
                            <div class="col-md-8">
                                <input id="contact_last_name" class="form-control" type="text" name="contact_last_name" value="{{ v('contact_last_name') }}" placeholder="Last Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="contact_email">Email</label>
                            <div class="col-md-8">
                                <input id="contact_email" class="form-control" type="email" name="contact_email" value="{{ v('contact_email') }}" placeholder="Email">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="contact_work_phone">Work Phone</label>
                            <div class="col-md-8">
                                <input id="contact_work_phone" class="form-control" type="text" name="contact_work_phone" value="{{ v('contact_work_phone') }}" placeholder="Work Phone">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="contact_mobile_phone">Mobile Phone</label>
                            <div class="col-md-8">
                                <input id="contact_mobile_phone" class="form-control" type="text" name="contact_mobile_phone" value="{{ v('contact_mobile_phone') }}" placeholder="Mobile Phone">
                            </div>
                        </div>

                        <hr/>

                        <div class="row_footer">
                           <div class="col-md-12 text-center grid_footer">
                                <button class="btn btn-primary grid_btn" type="submit">Save</button>
                                <a href="{{ url("/cabinet/my-org")}}" class="btn btn-default cancle_btn">Cancel</a>
                            </div>
                        </div>
                        <br/><br/>

                    </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
<script type="text/javascript">

    $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    $(document).ready( function() {
        $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
            $('.file-name').text(label);
        });
        $('#city_area').combobox({
            bsVersion: '3'
        });
    });

    $('#my-organization-form').validate({
        rules: {
            organization_name: {
                required: true
            },
            city_id: {
                requiredSelect: true
            },
            contact_first_name: {
                required: true
            },
            work_phone: {
                phoneNumber: true
            },
            mobile_phone: {
                phoneNumber: true
            },
            contact_work_phone: {
                phoneNumber: true
            },
            contact_mobile_phone: {
                phoneNumber: true
            }
        }
    });

</script>
@endsection
