<div class="col-md-6">
    <div class="panel panel-default">
        <div class="panel-body home-events-panel bk-brand text-light">
            <div class="stat-panel home-events">
                <div class="events-text"><i class="glyphicon glyphicon-calendar"></i> Events</div>
                @if (count($admin->events()))
                    <div id="events-list">
                        <ul class="list">
                            @foreach($admin->events() as $row)
                                <li>{{style_date($row['event_date'])}} - {{$row['event_type']}} - {{$row['event_text']}}</li>
                            @endforeach
                        </ul>
                        <ul class="pagination"></ul>
                    </div>
                @else
                    There are no events.
                @endif
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script type="text/javascript">

    var options = {
      valueNames: [ 'name', 'category' ],
      page: 10,
      plugins: [
        ListPagination({})
      ]
    };

    var listObj = new List('events-list', options);

</script>
@endsection
