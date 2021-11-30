<?php

namespace Eerzho\LaravelComponents\Providers;

use Eerzho\LaravelComponents\Console\Commands\MakeCommands\MakeRepository;
use Eerzho\LaravelComponents\Console\Commands\MakeCommands\MakeSearch;
use Eerzho\LaravelComponents\Console\Commands\MakeCommands\MakeService;
use Eerzho\LaravelComponents\Console\Commands\PublishStubCommand;
use Illuminate\Support\ServiceProvider;

class EerzhoLaravelComponentsProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                PublishStubCommand::class,
                MakeRepository::class,
                MakeSearch::class,
                MakeService::class,
            ]);
        }
    }
}
