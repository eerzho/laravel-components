<?php

namespace Eerzho\LaravelComponents\Console\Commands\MakeCommands;

use Eerzho\LaravelComponents\Commands\BaseCommand\BaseCommand;

class MakeRepository extends BaseCommand
{
    protected $name = 'make:repository';

    protected $description = 'Create new Repository';

    protected $type = 'Repository';

    /**
     * @return string
     */
    protected function getStub()
    {
        return base_path('stubs/repository.stub');
    }
}
