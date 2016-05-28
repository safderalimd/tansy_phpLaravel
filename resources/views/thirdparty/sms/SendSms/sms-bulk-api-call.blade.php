<SMS>
    <Account Name="{{$username}}" Password="{{$password}}" Test="{{$test}}" Info="1" JSON="1">
    <Sender From="TXTLCL">
        <Messages>
            @foreach ($messages as $message)
                <Msg Number="{{$message['number']}}">
                    <Text>{{$message['text']}}</Text>
                </Msg>
            @endforeach
        </Messages>
    </Sender>
    </Account>
</SMS>
