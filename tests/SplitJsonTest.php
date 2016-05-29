<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Modules\thirdparty\sms\SmsSender;

class SplitJsonTest extends TestCase
{
    /** @test */
    public function it_parses_multiple_json_ojbects()
    {
        $input = '{"warnings":[{"message":"Number is in DND","numbers":"919676945352"}],"errors":[{"code":51,"message":"No valid numbers specified"}],"status":"failure"}{"balance":995,"batch_id":244712728,"cost":1,"num_messages":1,"message":{"num_parts":1,"sender":"TXTLCL","content":"Exam Result: TEL-4,HIN-6,ENG-78,MAT-35,TOT=345,FAIL"},"receipt_url":"","custom":"88","messages":[{"id":"119713472","recipient":918801933344}],"status":"success"}';

        $expected = [
            '{"warnings":[{"message":"Number is in DND","numbers":"919676945352"}],"errors":[{"code":51,"message":"No valid numbers specified"}],"status":"failure"}',
            '{"balance":995,"batch_id":244712728,"cost":1,"num_messages":1,"message":{"num_parts":1,"sender":"TXTLCL","content":"Exam Result: TEL-4,HIN-6,ENG-78,MAT-35,TOT=345,FAIL"},"receipt_url":"","custom":"88","messages":[{"id":"119713472","recipient":918801933344}],"status":"success"}',
        ];

        $this->assertEquals(SmsSender::jsonSplitObjects($input), $expected);
    }
}
