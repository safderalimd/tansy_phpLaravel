<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DateFormatTest extends TestCase
{
    /** @test */
    public function it_styles_date()
    {
        $date = '2016-02-14';
        $this->assertEquals('Feb 14th, 2016', style_date($date));
    }
}
