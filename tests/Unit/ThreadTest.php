<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    protected $thread;

    public function setUp()
    {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }

    /**
     * A thread can make a string path
     *
     * @test
     */
    function a_thread_can_make_a_string_path()
    {
        $thread = create('App\Thread');
        $this->assertEquals(
            "/threads/{$thread->channel->slug}/{$thread->id}",
            $thread->path()
        );
    }

    /**
     * A thread has replies
     *
     * @test
     */
    function a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    /**
     * A thread has a creator
     *
     * @test
     */
    function a_thread_has_a_creator()
    {
        $this->assertInstanceOf('App\User', $this->thread->owner);
    }

    /**
     * A thread can add a reply
     *
     * @test
     */
    function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }
    
    /**
     * A thread notifies all registered subscribers when a reply is added
     * 
     * @test
     */
    function a_thread_notifies_all_registered_subscribers_when_a_reply_is_added()
    {
        Notification::fake();

        $this->signIn()
            ->thread
            ->subscribe()
            ->addReply([
                'user_id' => 1,
                'body' => 'The cake is a lie'
        ]);

        Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);
    }

    /**
     * A thread belongs to a channel
     *
     * @test
     */
    function a_thread_belongs_to_a_channel()
    {
        $thread = create('App\Thread');
        $this->assertInstanceOf('App\Channel', $thread->channel);
    }

    /**
     * A thread can be subscribed to
     *
     * @test
     */
    function a_thread_can_be_subscribed_to()
    {
        // Given we have a thread
        $thread = create('App\Thread');

        // And a user who is subscribed to the thread
        $thread->subscribe($userId = 1);

        // Then we should be able to fetch all threads the user has subscribed to
        $this->assertEquals(
            1,
            $thread->subscriptions()
            ->where('user_id', $userId)
            ->count()
        );
    }

    /**
     * A thread can be unsubscribed from
     *
     * @test
     */
    function a_thread_can_be_unsubscribed_from()
    {
        // Given we have a thread
        $thread = create('App\Thread');

        // And a user who is subscribed to the thread
        $thread->subscribe($userId = 1);

        // And the user cancels his subscription to the thread
        $thread->unsubscribe($userId);

        // Then there should not be any user subscribed to the thread
        $this->assertCount(0, $thread->subscriptions);
    }

    /**
     * Thread knows if the authenticated user is subscribed to it
     * 
     * @test
     */
    function thread_knows_if_authenticated_user_is_subscribed_to_it()
    {
        // Given we have a thread
        $thread = create('App\Thread');

        // And a user who is authenticated
        $this->signIn();

        $this->assertFalse($thread->isSubscribedTo);

        // Subscribe to the thread
        $thread->subscribe();

        // Then the use should be subscribed to the thread
        $this->assertTrue($thread->isSubscribedTo);
    }
    
    /**
     * A thread can check if the authenticated user has read all replies
     * 
     * @test
     */
    function a_thread_can_check_if_the_authenticated_user_has_read_all_replies()
    {
        $this->signIn();

        $thread = create('App\Thread');


        tap(auth()->user(), function ($user) use ($thread) {
            $this->assertTrue($thread->hasUpdatesFor($user));

            // Simulate that the user visited the thread.
            $user->read($thread);

            $this->assertFalse($thread->hasUpdatesFor($user));
        });
    }
}
