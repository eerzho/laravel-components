<?php

namespace Eerzho\LaravelComponents\Interfaces\Morphable;

interface MorphableInterface
{
    /**
     * @return string
     */
    public function getMorphClass();

    /**
     * @return string|int
     */
    public function getKey();
}
