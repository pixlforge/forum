<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SubscribeToThreadsTest extends TestCase
{
    use DatabaseMigrations;
    
    /**
     * A user can subscribe to threads
     * 
     * @test
     */
    function a_user_can_subscribe_to_threads()
    {
        $this->signIn();

        // Given we have a thread
        $thread = create('App\Thread');

        // And the user subscribes to the thread
        $this->post($thread->path() . '/subscriptions');

        $this->assertCount(1, $thread->fresh()->subscriptions);
    }
    
    /**
     * A user can unsubscribe from threads
     * 
     * @test
     */
    function a_user_can_unsubscribe_from_threads()
    {
        $this->signIn();

        // Given we have a thread
        $thread = create('App\Thread');

        // And the user subscribes to the thread
        $thread->subscribe();

        // And the user unsubscribes from the thread
        $this->delete($thread->path() . '/subscriptions');

        // Then there should not be any thread subscriptions
        $this->assertCount(0, $thread->subscriptions);
    }
}
