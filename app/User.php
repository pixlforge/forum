<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_path', 'confirmation_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email'
    ];

    /**
     * Cast properties to a given type
     *
     * @var array
     */
    protected $casts = [
        'confirmed' => 'boolean'
    ];

    /**
     * Route key name.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    /**
     * Check wether the authenticated User is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return in_array($this->name, ['John Doe', 'Jane Doe']);
    }

    /**
     * Inverse of isAdmin method.
     *
     * @return bool
     */
    public function isNotAdmin()
    {
        return ! $this->isAdmin();
    }

    /**
     * @return mixed
     */
    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * @param $thread
     */
    public function read($thread)
    {
        cache()->forever(
            $this->visitedThreadCacheKey($thread),
            \Carbon\Carbon::now()
        );
    }

    /**
     * @param $thread
     * @return string
     */
    public function visitedThreadCacheKey($thread)
    {
        return sprintf("users.%s.visits.%s", $this->id, $thread->id);
    }

    /**
     * @return mixed
     */
    public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }

    public function getAvatarPathAttribute($avatar)
    {
        return $avatar ?: 'avatars/default.jpg';
    }

    public function confirm()
    {
        $this->confirmed = true;
        $this->confirmation_token = null;

        $this->save();
    }
}
