<?php

namespace Eerzho\LaravelComponents\Console\Commands\MakeCommands;

use Eerzho\LaravelComponents\Commands\BaseCommand\BaseCommand;

class MakeSearch extends BaseCommand
{
    protected $name = 'make:search';

    protected $description = 'Create new Search';

    protected $type = 'Search';

    /**
     * @return string
     */
    protected function getStub()
    {
        return base_path('stubs/search.stub');
    }
}
