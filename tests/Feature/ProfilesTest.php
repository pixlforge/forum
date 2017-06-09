<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProfilesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A user has a profile
     * 
     * @test
     */
    function a_user_has_a_profile()
    {
        $user = create('App\User');
        
        $this->get('/profiles/' . $user->name)
            ->assertSee($user->name);
    }

    /**
     * Profiles display all threads created by the associated user
     * 
     * @test
     */
    function profiles_display_all_threads_created_by_the_associated_user()
    {
        $user = create('App\User');
        
        $thread = create('App\Thread', ['user_id' => $user->id]);
        
        $this->get('/profiles/' . $user->name)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

}
