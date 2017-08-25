<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * It has an owner
     */
    public function test_it_has_an_owner()
    {
        $reply = factory('App\Reply')->create();
        $this->assertInstanceOf('App\User', $reply->owner);
    }
    
    /**
     * It knows if it was just published
     * 
     * @test
     */
    function it_knows_if_it_was_just_published()
    {
        $reply = create('App\Reply');
        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();
        $this->assertFalse($reply->wasJustPublished());
    }
    
    /**
     * It can detect all mentioned users in the body
     * 
     * @test
     */
    function it_can_detect_all_mentioned_users_in_the_body()
    {
        $reply = create('App\Reply', [
            'body' => '@JaneDoe wants to talk to @JohnDoe.'
        ]);

        $this->assertEquals(['JaneDoe', 'JohnDoe'], $reply->mentionedUsers());
    }
    
    /**
     * It wraps mentioned usernames in the body within anchor tags
     * 
     * @test
     */
    function it_wraps_mentioned_usernames_in_the_body_within_anchor_tags()
    {
        $reply = create('App\Reply', [
           'body' => 'Hello, @JaneDoe, how are you?'
        ]);

        $this->assertEquals(
            'Hello, <a href="/profiles/JaneDoe">@JaneDoe</a>, how are you?',
            $reply->body
        );
    }
}
