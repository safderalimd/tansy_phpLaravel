<div class="form-group">
    <label class="col-md-4 control-label" for="{{$keyId}}">{{ $label }}</label>
    <div class="col-md-8">
        <select id="{{$keyId}}" class="form-control" name="{{$keyId}}">
            @foreach($options as $option)
                <option value="{!!$option[$keyId]!!}">{!!$option[$keyName]!!}</option>
            @endforeach
        </select>
    </div>
</div>
