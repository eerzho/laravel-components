<?php

namespace Eerzho\LaravelComponents\Console\Commands\MakeCommands;

use Eerzho\LaravelComponents\Commands\BaseCommand\BaseCommand;

class MakeService extends BaseCommand
{
    protected $name = 'make:service';

    protected $description = 'Create new Service';

    protected $type = 'Service';

    /**
     * @return string
     */
    protected function getStub()
    {
        return base_path('stubs/service.stub');
    }
}
