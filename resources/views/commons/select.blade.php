<div class="form-group">
    <label class="col-md-4 control-label" for="{{ $name }}">{{ $label }}</label>
    <div class="col-md-8">
        <select id="{{ $name }}" class="form-control" name="{{ $name }}">
            @foreach($options as $option)
                <option {{ s($name, $option[$keyId]) }} value="{!! $option[$keyId] !!}">
                    {!! $option[$keyName] !!}
                </option>
            @endforeach
        </select>
    </div>
</div>
