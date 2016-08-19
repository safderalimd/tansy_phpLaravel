<SMS>
    <Account Name="{{$username}}" Hash="{{$hash}}" Test="{{$test}}" Info="1" JSON="1">
    <Sender From="{{$senderId}}">
        <Messages>
            @foreach ($messages as $message)
                <Msg ID="{{$message['account_entity_id']}}" Number="{{$message['mobile_phone']}}">
                    <Text>{{$prefix}}{!!$message['sms_text']!!}</Text>
                </Msg>
            @endforeach
        </Messages>
    </Sender>
    </Account>
</SMS>
