<?php

namespace App;

use Illuminate\Support\Facades\Redis;

trait RecordsVisits
{
    /**
     * Record visits
     *
     * @return Thread
     */
    public function recordVisit()
    {
        Redis::incr($this->visitsCacheKey());

        return $this;
    }

    /**
     * Return number of visits
     *
     * @return mixed
     */
    public function visits()
    {
        return Redis::get($this->visitsCacheKey());
    }

    /**
     * Reset the number of visits
     *
     * @return Thread
     */
    public function resetVisits()
    {
        Redis::del($this->visitsCacheKey());

        return $this;
    }

    /**
     * Get the visit cache key for the model
     *
     * @return string
     */
    protected function visitsCacheKey()
    {
        return "threads.{$this->id}.visits";
    }
}