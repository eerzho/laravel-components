<?php

namespace Eerzho\LaravelComponents\Interfaces\BaseException;

interface BaseExceptionInterface
{
    /**
     * @return string
     */
    public function getMessage();

    /**
     * @return int
     */
    public function getCode();
}
