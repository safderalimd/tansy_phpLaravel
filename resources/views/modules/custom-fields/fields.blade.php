@section('custom-fields')
@if (count($fields))
<div class="row"><div class="col-md-3 pull-left"><h3>Custom Fields</h3></div></div>
    <?php $validationRules = []; ?>
    @foreach ($fields as $field)

        @if (isset($field['ui_label']) && isset($field['db_column_name']) && isset($field['input_type']))
            <?php
                $isMandatory = false;
                if (isset($field['mandatory_input']) && $field['mandatory_input'] == 1) {
                    $isMandatory = true;
                }

                if ($isMandatory) {
                    if ($field['input_type'] == 'Free Text') {
                        $validationRules[] = $field['db_column_name'] . ': {required:true}';
                    } elseif ($field['input_type'] == 'Date Picker') {
                        $validationRules[] = $field['db_column_name'] . ': {required:true, dateISO: true}';
                    } elseif ($field['input_type'] == 'Drop Down') {

                    }
                }
            ?>

            @if ($field['input_type'] == 'Free Text')
                <div class="form-group">
                    <label class="col-md-4 control-label @if($isMandatory) required @endif" for="{{$field['db_column_name']}}">{{$field['ui_label']}}</label>
                    <div class="col-md-8">
                        <input id="{{$field['db_column_name']}}" data-type="text" class="custom-field-input form-control" type="text" name="{{$field['db_column_name']}}" value="{{ v($field['db_column_name']) }}" placeholder="{{$field['ui_label']}}">
                    </div>
                </div>

            @elseif ($field['input_type'] == 'Date Picker')
                <div class="form-group">
                    <label class="col-md-4 control-label @if($isMandatory) required @endif" for="{{$field['db_column_name']}}">{{$field['ui_label']}}</label>
                    <div class="col-md-8">
                        <div class="input-group date">
                            <input onchange="$(this).valid()" id="{{$field['db_column_name']}}" data-type="date" class="custom-field-input form-control" type="text" name="{{$field['db_column_name']}}" value="{{ v($field['db_column_name']) }}" placeholder="{{$field['ui_label']}}">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><span
                                            class="glyphicon glyphicon-calendar"></span></button>
                            </span>
                        </div>
                    </div>
                </div>

            @elseif ($field['input_type'] == 'Drop Down')
                <?php $values = $model->getDropdownValues($field['drop_down_sql']); ?>
                @if (isset($values[0]))
                    <?php $keyId = key($values[0]); ?>
                    @include('commons.select', [
                        'label'    => $field['ui_label'],
                        'name'     => $field['db_column_name'],
                        'options'  => $values,
                        'keyId'    => $keyId,
                        'keyName'  => $keyId,
                        'required' => $isMandatory,
                        'cssClass' => 'custom-field-input',
                        'selectDataAttr' => 'data-type="select"',
                    ])
                @endif

            @elseif ($field['input_type'] == 'Checkbox')
                <div class="form-group">
                    <div class="col-md-offset-4 col-md-8">
                        <div class="checkbox">
                            <label>
                                <input id="{{$field['db_column_name']}}" data-type="checkbox" class="custom-field-input" {{ c($field['db_column_name']) }} name="{{$field['db_column_name']}}" type="checkbox"> {{$field['ui_label']}}
                            </label>
                        </div>
                    </div>
                </div>
            @endif

        @endif

    @endforeach
@endif

    <input type="hidden" name="custom_fields_list" id="custom_fields_list" value="">

@endsection

@section('validation-rules')
    @if (!empty($validationRules))
        ,
        {!! implode(',', $validationRules) !!}
    @endif
@endsection

@section('custom-fields-scripts')
<script type="text/javascript">

    function append_custom_fields() {
        var customFields = $('.custom-field-input').map(function() {
            var value = '';
            var name = $(this).attr('name');
            var type = $(this).attr('data-type');

            if (type == 'text') {
                value = $(this).val();
            } else if (type == 'date') {
                value = $(this).val();
            } else if (type == 'select') {
                value = $(this).find('option:selected').text();
            } else if (type == 'checkbox') {
                value = '0';
                if ($(this).is(':checked')) {
                    value = '1';
                }
            }

            if (typeof value == 'string') {
                value = value.trim();
                value = value.replace(/\|/g, '');
                value = value.replace(/\$<>\$/g, '');
            }

            return name + '$<>$' + value;
        }).get();

        $('#custom_fields_list').val(customFields.join('|'));
    }

</script>
@endsection
