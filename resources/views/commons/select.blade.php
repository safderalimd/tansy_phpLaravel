<div class="form-group">
    <label class="col-md-4 @if (isset($required) && $required) required @endif control-label" for="{{ $name }}">{{ $label }}</label>
    <div class="col-md-8">
        <select id="{{ $name }}" class="form-control" name="{{ $name }}">
            @if (isset($none))
                <option value="none">{{$none}}</option>
            @endif
            @foreach($options as $option)
                <?php
                    $dataAttribute = '';
                    if (isset($data) && isset($dataName)) {
                        $dataAttribute = 'data-' . $dataName . '="' . $option[$data] . '"';
                    }
                ?>
                <option {!! $dataAttribute !!} {{ s($name, $option[$keyId]) }} value="{{ $option[$keyId] }}">{{ $option[$keyName] }}</option>
            @endforeach
        </select>
    </div>
</div>
