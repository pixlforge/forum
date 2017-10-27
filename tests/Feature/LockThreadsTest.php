<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LockThreadsTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    function users_may_not_lock_threads()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->post(route('locked-threads.store', $thread))
            ->assertRedirect(route('threads'));

        $this->assertFalse(!! $thread->fresh()->locked);
    }

    /** @test */
    function admins_can_lock_threads()
    {
        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->post(route('locked-threads.store', $thread))->assertStatus(200);

        $this->assertTrue(!! $thread->fresh()->locked, 'Failed asserting the thread was locked');
    }

    /** @test */
    function a_locked_thread_may_not_receive_new_replies()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $thread->lock();

        $this->post($thread->path() . '/replies', [
            'body' => 'Foobar',
            'user_id' => create('App\User')->id
        ])->assertStatus(403);
    }
}
