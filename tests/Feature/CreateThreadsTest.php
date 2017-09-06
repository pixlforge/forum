<?php

namespace Tests\Feature;

use App\Activity;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Authenticated user can visit thread creation page
     *
     * @test
     */
    function authenticated_user_can_visit_thread_creation_page()
    {
        $this->signIn();
        $this->get('/threads/create')
            ->assertSee('Create');
    }

    /**
     * Guests may not create threads
     *
     * @test
     */
    function guests_may_not_create_threads()
    {
        $this->withExceptionHandling();
        
        $this->post(route('threads'))
            ->assertRedirect('/login');

        $this->get('/threads/create')
            ->assertRedirect('/login');
    }
    
    /**
     * New users must first confirm their email address before creating threads
     * 
     * @test
     */
    function new_users_must_first_confirm_their_email_address_before_creating_threads()
    {
        $user = factory('App\User')->states('unconfirmed')->create();
        $this->signIn($user);

        $thread = make('App\Thread');

        $this->post(route('threads'), $thread->toArray())
            ->assertRedirect(route('threads'))
            ->assertSessionHas('flash', 'You must first confirm your email address');
    }

    /**
     * A user can create new forum threads
     *
     * @test
     */
    function a_user_can_create_new_forum_threads()
    {
        $this->withExceptionHandling();
        $this->signIn();

        $thread = make('App\Thread');
        $response = $this->post(route('threads'), $thread->toArray());

//        dd($response->headers->get('Location'));

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
    
    /**
     * Unauthorized users may not delete threads
     * 
     * @test
     */
    function unauthorized_users_may_not_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread');

        $this->delete($thread->path())->assertRedirect(route('login'));

        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);
    }
    
    /**
     * Authorized users can delete threads
     * 
     * @test
     */
    function authorized_users_can_delete_threads()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());
        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        $this->assertEquals(0, Activity::count());
    }

    /**
     * @param array $overrides
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post(route('threads'), $thread->toArray());
    }

    /**
     * A thread requires a title
     *
     * @test
     */
    function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /**
     * A thread requires a body
     *
     * @test
     */
    function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /**
     * A thread requires a valid channel
     *
     * @test
     */
    function a_thread_requires_a_valid_channel()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }
}