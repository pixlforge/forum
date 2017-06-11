<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use RecordsActivity;

    /**
     * Disable mass assignment protection for this model
     */
    protected $guarded = [];

    public function favorited()
    {
        return $this->morphTo();
    }
}
