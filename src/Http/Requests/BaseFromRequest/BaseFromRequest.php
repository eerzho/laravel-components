<?php

namespace Eerzho\LaravelComponents\Http\Requests\BaseFromRequest;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseFromRequest extends FormRequest
{
    /**
     * @return array
     */
   abstract public function rules(): array;
}
