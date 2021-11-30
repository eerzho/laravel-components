<?php

namespace Eerzho\LaravelComponents\Services\BaseService;

abstract class BaseService
{
    /**
     * @return bool
     */
    abstract public function run(): bool;
}
