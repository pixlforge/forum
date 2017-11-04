<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_thread_requires_a_title_and_body_to_be_updated()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->patch($thread->path(), [
            'title' => 'Changed title'
        ])->assertSessionHasErrors('body');

        $this->patch($thread->path(), [
            'body' => 'Changed body'
        ])->assertSessionHasErrors('title');
    }

    /** @test */
    function unauthorized_users_may_not_update_threads()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => create('App\User')->id]);

        $this->patch($thread->path(), [
            'title' => 'Changed title'
        ])->assertStatus(403);
    }

    /** @test */
    function a_thread_can_be_updated_by_its_creator()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->patch($thread->path(), [
            'title' => 'Changed title',
            'body' => 'Changed body'
        ]);

        tap($thread->fresh(), function ($thread) {
            $this->assertEquals('Changed title', $thread->title);
            $this->assertEquals('Changed body', $thread->body);
        });
    }
}
