<?php

namespace Eerzho\LaravelComponents\Console\Commands\MakeCommands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class MakeCrudCommand extends Command
{
    protected $signature = 'make:crud {name}';

    protected $description = 'Create all files for crud';

    private $model;

    /**
     * @return mixed
     */
    public function handle()
    {
        $this->call('make:model', [
            'name'        => $this->getNameForModel(),
            '--migration' => true,
            '--factory'   => true,
            '--policy'    => true,
            '--seed'     => true,
        ]);

        $this->call('make:controller', [
            'name'  => $this->getNameForController(),
            '--api' => true,
        ]);

        $this->call('make:request', [
            'name' => $this->getNameForRequest(0),
        ]);

        $this->call('make:request', [
            'name' => $this->getNameForRequest(1),
        ]);

        $this->call('make:resource', [
            'name' => $this->getNameForResource(),
        ]);

        $this->call('make:repository', [
            'name' => $this->getNameForRepository(),
        ]);

        $this->call('make:search', [
            'name' => $this->getNameForSearch()
        ]);

        $this->call('make:service', [
            'name' => $this->getNameForService(1)
        ]);

        $this->call('make:service', [
            'name' => $this->getNameForService(0)
        ]);

        $this->info('All done!');

        return CommandAlias::SUCCESS;
    }

    /**
     * @return string
     */
    protected function getArgument()
    {
        return $this->model ?: $this->model = class_basename($this->argument('name'));
    }

    /**
     * @return string
     */
    protected function getNameForModel()
    {
        return $this->getArgument() . '/' . $this->getArgument();
    }

    /**
     * @return string
     */
    protected function getNameForController()
    {
        return 'Api/' . $this->getArgument() . '/' . $this->getArgument() . 'Controller';
    }

    /**
     * @param bool $val
     *
     * @return string
     */
    protected function getNameForRequest(bool $val)
    {
        return $this->getArgument() . '/' . $this->getArgument() . ($val ? 'Create' : 'Update') . 'Request';
    }

    /**
     * @return string
     */
    protected function getNameForResource()
    {
        return $this->getArgument() . '/' . $this->getArgument() . 'Resource';
    }

    /**
     * @return string
     */
    protected function getNameForRepository()
    {
        return $this->getArgument() . '/' . $this->getArgument() . 'Repository';
    }

    /**
     * @return string
     */
    protected function getNameForSearch()
    {
        return $this->getArgument() . '/' . $this->getArgument() . 'Search';
    }

    /**
     * @param bool $val
     *
     * @return string
     */
    protected function getNameForService(bool $val)
    {
        return $this->getArgument() . '/' . $this->getArgument() . ($val ? 'Create' : 'Update') . 'Service';
    }
}
