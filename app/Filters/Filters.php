<?php

namespace App\Filters;

use Illuminate\Http\Request;

/**
 * Filters abstract class
 */
abstract class Filters
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * The Eloquent Builder
     * 
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [];

    /**
     * Filters constructor
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply the filters
     *
     * @param $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    /**
     * Fetch all relevant filters from the request
     *
     * @return array
     */
    public function getFilters()
    {
        return array_filter(request()->only($this->filters));
    }

}





