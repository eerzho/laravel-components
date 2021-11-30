<?php

namespace Eerzho\LaravelComponents\Commands\BaseCommand;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

abstract class BaseCommand extends GeneratorCommand
{
    private $className;

    /**
     * @return string
     */
    protected function getNameInput()
    {
        return $this->getClassName();
    }

    /**
     * @return string
     */
    protected function getClassName()
    {
        return $this->className ?: $this->className = class_basename($this->argument('name'));
    }

    /**
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $argument = $this->argument('name');
        $namespace = '\\' . Str::plural($this->type);

        if (($beforeLast = Str::beforeLast($argument, '/')) != $this->getClassName()) {
            $namespace .= '\\' . Str::replace('/', '\\', $beforeLast);
        }

        return $rootNamespace . $namespace;
    }
}
