@extends('layout.cabinet')

@section('title', 'Custom Fields')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th"></i>
                    <h3>Custom Fields{{ form_label() }}</h3>
                </div>

                <div class="panel-body edit_form_wrapper">
                    <section class="form_panel">

                    @include('commons.errors')

                    <form id="fields-form" class="form-horizontal" action="{{ form_action_full() }}" method="POST">
                        {{ csrf_field() }}

                        <?php
                            $disabled = false;
                            if (!$fields->isNewRecord()) {
                                $disabled = true;
                            }
                        ?>
                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-8">
                                <div class="checkbox">
                                    <label>
                                        @if($fields->isNewRecord())
                                            <input checked="checked" name="active" type="checkbox">
                                        @else
                                            <input {{ c('active') }} name="active" type="checkbox">
                                        @endif
                                        Custom field is Active?
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-8">
                                <div class="checkbox">
                                    <label>
                                        <input {{ c('mandatory_input') }} name="mandatory_input" type="checkbox">
                                        Input to custom field is mandatory on data entry screen?
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-8">
                                <div class="checkbox">
                                    <label>
                                        <input @if($disabled) disabled="disabled" @endif {{ c('visible_in_grid') }} name="visible_in_grid" type="checkbox">
                                        Show custom field in Grid screen?
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="ui_label">UI Label</label>
                            <div class="col-md-8">
                                <input id="ui_label" class="form-control" type="text" name="ui_label" value="{{ v('ui_label') }}" placeholder="UI Label">
                            </div>
                        </div>

                        @include('commons.select', [
                            'label'    => 'Data Type' ,
                            'name'     => 'data_type_id',
                            'options'  => $fields->fieldDataType(),
                            'keyId'    => 'data_type_id',
                            'keyName'  => 'data_type',
                            'none'     => 'Select a data type..',
                            'disabled' => $disabled,
                            'required' => true,
                        ])

                        @include('commons.select', [
                            'label'    => 'Input Type' ,
                            'name'     => 'input_type_id',
                            'options'  => $fields->fieldInputType(),
                            'keyId'    => 'input_type_id',
                            'keyName'  => 'input_type',
                            'none'     => 'Select an input type..',
                            'disabled' => $disabled,
                            'required' => true,
                        ])

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="input_length">Input Length</label>
                            <div class="col-md-8">
                                <input id="input_length" class="form-control" type="text" name="input_length" value="{{ v('input_length') }}" placeholder="Input Length">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="order_sequence">Order Sequence</label>
                            <div class="col-md-8">
                                <input id="order_sequence" class="form-control" type="text" name="order_sequence" value="{{ v('order_sequence') }}" placeholder="Order Sequence">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-8">
                                <div class="checkbox">
                                    <label>
                                        <input {{ c('existing') }} name="existing" id="existing" type="checkbox">
                                        Existing Dropdown?
                                    </label>
                                </div>
                            </div>
                        </div>

                        <?php
                            if ($fields->isNewRecord()) {
                                $disabledDropdown = true;
                            } elseif (!$fields->isNewRecord() && old('existing')) {
                                $disabledDropdown = false;
                            } else {
                                $disabledDropdown = true;
                            }
                        ?>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="custom_field_list">Drop down values</label>
                            <div class="col-md-8">
                                <input id="custom_field_list" @if(!$disabledDropdown) disabled="disabled" @endif class="form-control" type="text" name="custom_field_list" value="{{ v('custom_field_list') }}" placeholder="Drop down values">
                                (Note: Separate each item with a comma.)
                            </div>
                        </div>

                        @include('commons.select', [
                            'label'    => 'Existing Dropdowns',
                            'name'     => 'primary_key_id',
                            'options'  => $fields->existingDropDown(),
                            'keyId'    => 'primary_key_id',
                            'keyName'  => 'list_name',
                            'data'     => 'row_type',
                            'dataName' => 'rowType',
                            'disabled' => $disabledDropdown,
                            'none'     => 'Select a dropdown..',
                        ])

                        <input type="hidden" name="row_type" id="row_type" value="">

                        <div class="row grid_footer">
                           <div class="col-md-offset-4 col-md-8">
                                <button class="btn btn-primary grid_btn" type="submit">Save</button>
                                <a href="{{ url("/cabinet/custom-fields")}}" class="btn btn-default cancle_btn">Cancel</a>
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


    $('#existing').change(function() {
        if ($(this).is(':checked')) {
            $('#custom_field_list').prop('disabled', true);
            $('#primary_key_id').prop('disabled', false);
        } else {
            $('#custom_field_list').prop('disabled', false);
            $('#primary_key_id').prop('disabled', true);
        }
    });

    // When submitting the form, prepend all selected checkboxes
    $('#fields-form').submit(function() {
        if (! $('#fields-form').valid()) {
            return false;
        }

        var rowType = $('#primary_key_id option:selected').attr('data-rowType');
        $('#row_type').val(rowType);

        return true;
    });

    $('#fields-form').validate({
        rules: {
            ui_label: {
                required: true
            },
            data_type_id: {
                requiredSelect: true,
            },
            input_type_id: {
                requiredSelect: true,
            },
            input_length: {
                number: true,
                min: 1,
                max: 50
            },
            order_sequence: {
                number: true
            }
        }
    });

</script>
@endsection
