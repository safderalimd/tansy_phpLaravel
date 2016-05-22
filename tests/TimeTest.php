<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TimeTest extends TestCase
{
    /** @test */
    public function it_shows_current_date()
    {
        $this->assertEquals(date('Y-m-d'), current_date());
    }

    /** @test */
    public function it_shows_current_time()
    {
        $this->assertEquals(date('H:i:s'), current_time());
    }
}
