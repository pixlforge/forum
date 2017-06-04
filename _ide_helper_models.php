<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Channel
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Thread[] $threads
 */
	class Channel extends \Eloquent {}
}

namespace App{
/**
 * App\Favorite
 *
 */
	class Favorite extends \Eloquent {}
}

namespace App{
/**
 * App\Reply
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Favorite[] $favorites
 * @property-read \App\User $owner
 */
	class Reply extends \Eloquent {}
}

namespace App{
/**
 * App\Thread
 *
 * @property-read \App\Channel $channel
 * @property-read \App\User $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Reply[] $replies
 * @method static \Illuminate\Database\Query\Builder|\App\Thread filter($filters)
 */
	class Thread extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 */
	class User extends \Eloquent {}
}

