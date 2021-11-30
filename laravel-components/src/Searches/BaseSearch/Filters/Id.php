<?php

namespace Eerzho\LaravelComponents\Searches\BaseSearch\Filters;

use Eerzho\LaravelComponents\Interfaces\Filter\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class Id implements FilterInterface
{
    /**
     * @param Builder $builder
     * @param mixed   $value
     *
     * @return Builder
     */
    public static function apply(Builder $builder, $value): Builder
    {
        return $builder->where('id', $value);
    }
}
