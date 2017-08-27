<?php

namespace App;

use Illuminate\Support\Facades\Redis;

class Visits
{
    protected $thread;

    /**
     * Visits constructor.
     */
    public function __construct($thread)
    {
        $this->thread = $thread;
    }

    /**
     * Record visits
     *
     * @return $this
     */
    public function record()
    {
        Redis::incr($this->cacheKey());

        return $this;
    }

    /**
     * Reset number of visits
     *
     * @return $this
     */
    public function reset()
    {
        Redis::del($this->cacheKey());

        return $this;
    }

    /**
     * Return number of visits
     *
     * @return mixed
     */
    public function count()
    {
        return Redis::get($this->cacheKey());
    }

    /**
     * Get the visit cache key for the model
     *
     * @return string
     */
    protected function cacheKey()
    {
        return "threads.{$this->thread->id}.visits";
    }
}