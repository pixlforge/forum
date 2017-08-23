<?php

namespace Tests\Unit;

use App\Inspections\Spam;
use Tests\TestCase;

class SpamTest extends TestCase
{
    /**
     * It checks for invalid keywords
     * 
     * @test
     */
    function it_checks_for_invalid_keywords()
    {
        $spam = new Spam();
        $this->assertFalse($spam->detect('Innocent reply here'));
        $this->expectException('Exception');
        $spam->detect('yahoo customer support');
    }
    
    /**
     * It checks for any key being held down
     * 
     * @test
     */
    function it_checks_for_any_key_being_held_down()
    {
        $spam = new Spam();
        $this->expectException('Exception');
        $spam->detect('Hello World aaaaaaaa');
    }
}
