<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PhoneNumberTest extends TestCase
{
    /** @test */
    public function format_10_digit_numbers()
    {
        $number = "1234567890";
        $this->assertEquals("123-456-7890", phone_number($number));
    }

    /** @test */
    public function format_9_digit_numbers()
    {
        $number = "123456789";
        $this->assertEquals("12-345-6789", phone_number($number));
    }

    /** @test */
    public function format_8_digit_numbers()
    {
        $number = "12345678";
        $this->assertEquals("1-234-5678", phone_number($number));
    }

    /** @test */
    public function dont_format_7_digit_numbers()
    {
        $number = "1234567";
        $this->assertEquals("1234567", phone_number($number));
    }

    /** @test */
    public function dont_format_6_digit_numbers()
    {
        $number = "123456";
        $this->assertEquals("123456", phone_number($number));
    }

    /** @test */
    public function format_11_digit_numbers()
    {
        $number = "12345678901";
        $this->assertEquals("1234-567-8901", phone_number($number));
    }
}
