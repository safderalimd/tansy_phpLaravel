@foreach($items as $item)
    <a href="@if($item->hasChildren()) {!!'#' . $item->id!!} @else {!!$item->url()!!} @endif "
       class="list-group-item @if($item->url() == app('request')->url()) selected @endif"
       @if ($item->hasChildren())
       data-toggle="collapse"
       data-parrent="{!! '#'.$item->parent !!}"
       @endif
    >
        {!!$item->title!!} @if($item->hasChildren()) <span class="caret"></span> @endif
    </a>

    @if($item->hasChildren())
        <?php
            $collapsed = 'collapse';
            if (currentMenuLink($item)) {
                $collapsed = 'collapsed in';
            }
        ?>
        <div class="{{$collapsed}}" id="{!!$item->id!!}" style="margin-left: 10px">
            <div id="{!!$item->id!!}">
                @include('include.sidebar-menuItem', array('items' => $item->children()))
            </div>
        </div>
    @endif

@endforeach
