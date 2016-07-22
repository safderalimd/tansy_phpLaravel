@extends('layout.cabinet')

@section('title', 'Help')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
    	<div class="panel-heading">
        	<i class="glyphicon glyphicon-th-list"></i>
        	<h3>Help</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <div class="row">
                <div class="col-md-12">
                    <form id="search-form" class="form-inline">
                        <label class="control-label">Search: </label>
                        <input type="text" name="search" id="help-search-box" class="form-control">
                    </form>
                </div>
            </div>

            <hr/>

            @foreach ($help->text() as $row)
            <div id="text-content">
                {!!$help->screenName($row['screen_name'])!!}
                <p><strong>Menu Link:</strong> {!!$row['menu_link']!!} </p>
                <p><strong>Features:</strong> {!!$row['features']!!} </p>
                <p><strong>Filters:</strong> {!!$row['filters']!!} </p>
                <p><strong>Security:</strong> {!!$row['security_groups']!!} </p>

                @if (count($row['images']))
                <p>
                    <strong>Image:</strong>
                    @foreach ($row['images'] as $image)
                        <a class="help-image" href="{{$image['image_url_value']}}">{{$image['image_link_name']}}</a><br/>
                    @endforeach
                </p>
                @endif

                @if (count($row['videos']))
                <p>
                    <strong>Video:</strong>
                    @foreach ($row['videos'] as $video)
                        <a href="{{$video['video_url_value']}}">{{$video['video_link_name']}}</a><br/>
                    @endforeach
                </p>
                @endif

                <p><strong>Description:</strong> {!!$row['description']!!} </p>
                <p><strong>Note:</strong> {!!$row['note']!!} </p>

                <hr/>
            @endforeach
            </div>

		    @include('commons.modal')

        </div>
    </div>
</div>

@endsection


@section('scripts')
<script type="text/javascript" src="/js/jquery.highlight.js"></script>
<script type="text/javascript">

function highlight() {
    var search = $('#help-search-box').val();
    $('#text-content').unhighlight();
    $('#text-content').highlight(search);
}

$(document).ready(function() {

    $('#help-search-box').keyup(function() {
        highlight();
    });
    $('#help-search-box').keypress(function() {
        highlight();
    });

    $('#search-form').submit(function() {
        return false;
    })

    $('.help-image').magnificPopup({type:'image'});

    // $('.help-image').on('click', function() {
    //     var href = $(this).attr('href');

    //     return false;
    // });

});


</script>
@endsection
