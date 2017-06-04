<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Unauthenticated users may not add replies
     *
     * @test
     */
    function unauthenticated_users_may_not_add_replies()
    {
        $this->withExceptionHandling()
            ->post('/threads/channel/thread-id/replies', [])
            ->assertRedirect('/login');
    }
    
    /**
     * An authenticated user may participate in forum threads
     *
     * @test
     */
    function an_authenticated_user_may_participate_in_forum_threads()
    {
        // Given we have an authenticated user
        $this->signIn();
        
        // And an existing thread
        $thread = create('App\Thread');

        // When the user adds a reply to the thread
        $reply = make('App\Reply');
        $this->post($thread->path() . '/replies', $reply->toArray());

        // Then their reply should be visible on the page
        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    /**
     * A reply requires a body
     *
     * @test
     */
    function a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}
