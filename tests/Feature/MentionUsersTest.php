<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MentionUsersTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Mentioned users in a reply are notified
     * 
     * @test
     */
    function mentioned_users_in_a_reply_are_notified()
    {
        $johndoe = create('App\User', ['name' => 'JohnDoe']);
        $this->signIn($johndoe);

        $janedoe = create('App\User', ['name' => 'JaneDoe']);

        $thread = create('App\Thread');

        $reply = make('App\Reply', [
            'body' => 'Look at this, @JaneDoe, @pixlforge.'
        ]);

        $this->json('post', $thread->path() . '/replies', $reply->toArray());

        $this->assertCount(1, $janedoe->notifications);
    }
}
