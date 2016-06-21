@extends('layout.cabinet')

@section('title', 'Schedule Payment')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th"></i>
                    <h3>Schedule Payment{!! form_label() !!}</h3>
                </div>

                <div class="panel-body edit_form_wrapper">
                    <section class="form_panel">

                    @include('commons.errors')

                    <form class="form-horizontal" id="payment-form" action="{{ form_action() }}" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <div class="checkbox">
                                    <label>
                                        @if($payment->isNewRecord())
                                            <input checked="checked" name="active" type="checkbox" disabled readonly> Active
                                        @else
                                            <input {{ c('active') }} name="active" type="checkbox"> Active
                                        @endif
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="facility_ids">Facility Type</label>
                            <div class="col-md-8">
                                <?php
                                    if (!is_array($payment->selectedFacilities)) {
                                        $payment->selectedFacilities = [];
                                    }
                                ?>
                                <select id="facility_ids" class="form-control" name="facility_ids">
                                    <option value="none">Select a facility type..</option>
                                    @foreach($payment->facilities() as $option)
                                        <option @if(in_array($option['facility_entity_id'], $payment->selectedFacilities)) selected @endif value="{{$option['facility_entity_id']}}">{{$option['facility_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="product">Name</label>
                            <div class="col-md-8">
                                <input id="product" class="form-control" type="text" name="schedule_name" value="{{ v('schedule_name') }}" placeholder="Name">
                            </div>
                        </div>

                        @include('commons.select', [
                            'label'    => 'Product' ,
                            'name'     => 'product_entity_id',
                            'options'  => $payment->products(),
                            'keyId'    => 'product_entity_id',
                            'keyName'  => 'product',
                            'none'     => 'Select a product..',
                            'required' => true,
                        ])

                        @include('commons.select', [
                            'label'    => 'Account Type' ,
                            'name'     => 'account_type_id',
                            'options'  => $payment->accountType(),
                            'keyId'    => 'entity_type_id',
                            'keyName'  => 'entity_type',
                            'none'     => 'Select an account type..',
                            'required' => true,
                        ])

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="subject_entity_id">Subject Account</label>
                            <div class="col-md-8">
                                <select id="subject_entity_id" class="form-control" name="subject_entity_id">
                                    <option value="none">Select a subject account..</option>
                                    @if (!$payment->isNewRecord())
                                        @foreach($payment->entityName() as $option)
                                            <option data-entityTypeId="{{$option['entity_type_id']}}" {{ s('subject_entity_id', $option['entity_id']) }} value="{!! $option['entity_id'] !!}">{!! $option['entity_name'] !!}</option>
                                        @endforeach
                                    @else
                                        @foreach($payment->entityName() as $option)
                                            <option data-entityTypeId="{{$option['entity_type_id']}}" @if ($accountEntityId == $option['entity_id']) {{'selected'}} @endif value="{!! $option['entity_id'] !!}">{!! $option['entity_name'] !!}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        @include('commons.select', [
                            'label'    => 'Frequency' ,
                            'name'     => 'frequency_id',
                            'options'  => $payment->frequency(),
                            'keyId'    => 'frequency_id',
                            'keyName'  => 'description',
                            'none'     => 'Select a frequency..',
                            'required' => true,
                        ])


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label required" for="start_date">Start Date</label>
                                    <div class="col-md-8">
                                        <div class="input-group date">
                                            <input id="start_date" class="form-control" type="text" name="start_date" value="{{ v('start_date') }}" placeholder="Start Date">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button"><span
                                                            class="glyphicon glyphicon-calendar"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label required" for="end_date">End Date</label>
                                    <div class="col-md-8">
                                        <div class="input-group date">
                                            <input id="end_date" class="form-control" type="text" name="end_date" value="{{ v('end_date') }}" placeholder="End Date">
                                            <span id="end-date-btn" class="input-group-btn">
                                                <button class="btn btn-default" type="button"><span
                                                            class="glyphicon glyphicon-calendar"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label required" for="amount">Amount</label>
                                    <div class="col-md-8">
                                        <input id="amount" class="form-control" type="text" name="amount" value="{{ v('amount') }}" placeholder="Amount">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label required" for="due_date_days_value">Due Days</label>
                                    <div class="col-md-8">
                                        <input id="due_date_days_value" class="form-control" type="text" name="due_date_days_value" value="{{ v('due_date_days_value') }}" placeholder="Due Days">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="hidden_frequency_text" id="hidden_frequency_text"/>

                        <div class="row">
                           <div class="col-md-12 text-center grid_footer">
                                <button class="btn btn-primary grid_btn" type="submit">Save</button>
                                <a href="{{ url("/cabinet/schedule-payment")}}" class="btn btn-default cancle_btn">Cancel</a>
                            </div>
                        </div>
                    </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
<script type="text/javascript">

    function isOneTimeFrequency() {
        var frequency = $("#frequency_id option:selected").text();
        frequency = frequency.trim().split(' ').join('');
        frequency = frequency.toLowerCase();

        if (frequency == 'onetime') {
            return true;
        }

        return false;
    }

    // when Frequency is OneTime disable end time and populate it with start time
    $('#frequency_id').change(function() {
        if (isOneTimeFrequency()) {
            $('#end_date').prop('disabled', true);
            $('#end-date-btn button').prop('disabled', true);
            $('#end_date').val($('#start_date').val());
        } else {
            $('#end-date-btn button').prop('disabled', false);
            $('#end_date').prop('disabled', false);
        }
    });
    // if Frequency is OneTime, update end time when start time changes
    $('#start_date').change(function() {
        if ($('#end_date').is(':disabled')) {
            $('#end_date').val($('#start_date').val());
        }
    });

    var allAccountOptions;

    function initAccountOptions() {
        if (isOneTimeFrequency()) {
            $('#end_date').prop('disabled', true);
            $('#end-date-btn button').prop('disabled', true);
            $('#end_date').val($('#start_date').val());
        }

        allAccountOptions = $('#subject_entity_id option');

        var selectedAccountTypeId = $('#subject_entity_id option:selected').attr('data-entityTypeId');

        $('#account_type_id option').each(function() {
            if (this.value == selectedAccountTypeId) {
                $(this).prop('selected',true);
            }
        });

        var selectedStudentId = $('#subject_entity_id option:selected').val();

        updateAccounts();

        $('#subject_entity_id option').each(function() {
            if (this.value == selectedStudentId) {
                $(this).prop('selected', true);
            } else {
                $(this).prop('selected', false);
            }
        });
    }

    function removeAllAccountOptions() {
        $('#subject_entity_id option').remove();
    }

    function populateAccountsSelectbox(accounts) {
        $(accounts).each(function() {
            $('#subject_entity_id').append($(this));
        });
    }

    function updateAccounts() {
        removeAllAccountOptions();

        var accountTypeId = $('#account_type_id option:selected').val();
        var filteredAccounts = $(allAccountOptions).filter(function() {
            if ($(this).attr('data-entityTypeId') == accountTypeId) {
                return true;
            }
            return false;
        }).get();

        populateAccountsSelectbox(filteredAccounts);
    }

    $('#account_type_id').change(function() {
        updateAccounts();
    });

    $(document).ready(function() {
        initAccountOptions();
    });


    // When submitting the form, prepend all selected checkboxes
    $('#payment-form').submit(function() {
        if (!$('#payment-form').valid()) {
            return false;
        }

        $('#hidden_frequency_text').val($("#frequency_id option:selected").text());
        return true;
    });

    $('#payment-form').validate({
        rules: {
            subject_entity_id: {
                requiredSelect: true
            },
            product_entity_id: {
                requiredSelect: true
            },
            frequency_id: {
                requiredSelect: true
            },
            schedule_name: {
                required: true
            },
            amount: {
                required: true,
                number: true,
                min: 0
            },
            start_date: {
                required: true,
                dateISO: true
            },
            end_date: {
                required: true,
                dateISO: true
            },
            due_date_days_value: {
                required: true,
                number: true,
                min: 0
            },
            facility_ids: {
                requiredSelect: true
            }
        }
    });

    $('#frequency_id').change(function() {
        $('#end_date').valid();
    });

    $('#start_date, #end_date').change(function() {
        $('#start_date').valid();
        $('#end_date').valid();
    });

</script>
@endsection
