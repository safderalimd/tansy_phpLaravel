<SMS>
    <Account Name="{{$username}}" Hash="{{$hash}}" Test="{{$test}}" Info="1" JSON="1">
    <Sender From="{{$senderId}}">
        <Messages>
            @foreach ($messages as $message)
                <?php
                    $smsText = $message['sms_text'];

                    if (strlen($smsText) > 145) {
                        $smsText = substr($smsText, 0, 145);
                    }
                ?>
                <Msg ID="{{$message['account_entity_id']}}" Number="{{$message['mobile_phone']}}">
                    <Text>{!!$smsText!!}</Text>
                </Msg>
            @endforeach
        </Messages>
    </Sender>
    </Account>
</SMS>
