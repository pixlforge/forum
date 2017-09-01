<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->signIn();
    }
    
    /**
     * A notification is prepared when a subscribed thread receives
     * a new reply that is not by the current user
     * 
     * @test
     */
    function a_notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply_that_is_not_by_the_current_user()
    {
        $thread = create('App\Thread')->subscribe();

        // Before the reply, there should be no notification
        $this->assertCount(0, auth()->user()->notifications);

        // Then each time a new reply is left
        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'The cake is a lie'
        ]);

        // Then there should be no notification to the user
        $this->assertCount(0, auth()->user()->fresh()->notifications);

        // When a reply is added by another user
        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'The cake is a lie'
        ]);

        // Then there should be a notification for the user
        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /**
     * A user can fetch their unread notifications
     *
     * @test
     */
    function a_user_can_fetch_their_unread_notifications()
    {
        create(DatabaseNotification::class);

        $this->assertCount(
            1,
            $this->getJson("/profiles/" . auth()->user()->name . "/notifications")->json()
        );
    }
    
    /**
     * A user can mark a notification as read
     * 
     * @test
     */
    function a_user_can_mark_a_notification_as_read()
    {
        create(DatabaseNotification::class);

        $user = auth()->user();

        // Then the user should have exactly one notification
        $this->assertCount(1, $user->unreadNotifications);

        $notificationId = $user->unreadNotifications->first()->id;

        // When the user has read the notification, we should delete the timestamp in the table
        $this->delete("/profiles/{$user->name}/notifications/{$notificationId}");

        // Then the user should not have any unread notification
        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }
}
