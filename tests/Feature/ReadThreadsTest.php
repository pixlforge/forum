<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadThreadsTest extends TestCase
{
    use RefreshDatabase;

    protected $thread;

    /**
     * Method setUp
     *
     * We need to call parent::setUp() because ReadThreadsTest extends TestCase
     */
    public function setUp()
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    /**
     * A user can view all threads
     *
     * @test
     */
    public function a_user_can_view_all_threads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /**
     * A user can read a single thread
     *
     * @test
     */
    public function a_user_can_read_a_single_thread()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    /**
     * A user can filter threads according to a tag
     *
     * @test
     */
    function a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /**
     * A user can filter threads by any username
     *
     * @test
     */
    function a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(create('App\User', ['name' => 'JohnDoe']));
        $threadByJohn = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByJohn = create('App\Thread');
        $this->get('/threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }

    /**
     * A user can filter threads by popularity
     *
     * @test
     */
    function a_user_can_filter_threads_by_popularity()
    {
        // With 2 replies, 3 replies, and 0 replies respectively
        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithNoReplies = $this->thread;

        // When I filter all threads by popularity
        $response = $this->getJson('threads?popular=1')->json();

        // Then they should be returned from most replies to least
        $this->assertEquals([3, 2, 0], array_column($response['data'], 'replies_count'));
    }
    
    /**
     * A user can filter threads by those that are unanswered
     * 
     * @test
     */
    function a_user_can_filter_threads_by_those_that_are_unanswered()
    {
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->getJson('/threads?unanswered=1')->json();

        $this->assertCount(1, $response['data']);
    }

    /**
     * A user can request all replies for a given thread
     * 
     * @test
     */
    function a_user_can_request_all_replies_for_a_given_thread()
    {
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->getJson($thread->path() . '/replies')->json();

        $this->assertCount(1, $response['data']);
    }

    /**
     * We record a new visit each time the thread is read
     * 
     * @test
     */
    function we_record_a_new_visit_each_time_the_thread_is_read()
    {
        $thread = create('App\Thread');
        $this->assertSame(0, $thread->visits);

        $this->call('GET', $thread->path());
        $this->assertEquals(1, $thread->fresh()->visits);
    }
}









