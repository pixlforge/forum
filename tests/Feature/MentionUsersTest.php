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
    
    /**
     * It can fetch all mentioned users starting with the given characters
     * 
     * @test
     */
    function it_can_fetch_all_mentioned_users_starting_with_the_given_characters()
    {
        create('App\User', ['name' => 'johndoe']);
        create('App\User', ['name' => 'janedoe']);
        create('App\User', ['name' => 'johnmoore']);

        $results = $this->json('GET', '/api/users', ['name' => 'john']);

        $this->assertCount(2, $results->json());
    }
}
