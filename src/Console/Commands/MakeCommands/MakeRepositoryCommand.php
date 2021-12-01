<?php

namespace Eerzho\LaravelComponents\Console\Commands\MakeCommands;

use Eerzho\LaravelComponents\Console\Commands\BaseCommand\BaseCommand;

class MakeRepositoryCommand extends BaseCommand
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
