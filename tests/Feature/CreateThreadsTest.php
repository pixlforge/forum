<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

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
        
        $this->post('/threads')
            ->assertRedirect('/login');

        $this->get('/threads/create')
            ->assertRedirect('/login');
    }

    /**
     * An authenticated user can create new forum threads
     *
     * @test
     */
    function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn();

        $thread = make('App\Thread');
        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
    
    /**
     * Guests cannot delete threads
     * 
     * @test
     */
    function guests_cannot_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread');

        $response = $this->delete($thread->path());
        $response->assertRedirect('/login');
    }
    
    /**
     * Threads may only be deleted by those who have permission
     * 
     * @test
     */
    function threads_may_only_be_deleted_by_those_who_have_permission()
    {
//        TODO
    }
    
    /**
     * A thread can be deleted
     * 
     * @test
     */
    function a_thread_can_be_deleted()
    {
        $this->signIn();

        $thread = create('App\Thread');
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());
        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
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
