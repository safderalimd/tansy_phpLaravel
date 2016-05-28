<SMS>
    <Account Name="{{$username}}" Password="{{$password}}" Test="{{$test}}" Info="1" JSON="1">
    <Sender From="TXTLCL">
        <Messages>
            @foreach ($messages as $message)
                <Msg ID="{{$message['account_entity_id']}}" Number="{{$message['mobile_phone']}}">
                    <Text>{{$message['sms_text']}}</Text>
                </Msg>
            @endforeach
        </Messages>
    </Sender>
    </Account>
</SMS>
