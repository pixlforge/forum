<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, RecordsActivity;

    /**
     * Don't apply mass assignment protection
     */
    protected $guarded = [];

    /**
     * Eager load related relationships
     */
    protected $with = ['owner', 'favorites'];
    
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

}
