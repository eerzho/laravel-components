<?php

namespace Eerzho\LaravelComponents\Providers;

use Eerzho\LaravelComponents\Console\Commands\MakeCommands\MakeCrudCommand;
use Eerzho\LaravelComponents\Console\Commands\MakeCommands\MakeRepositoryCommand;
use Eerzho\LaravelComponents\Console\Commands\MakeCommands\MakeSearchCommand;
use Eerzho\LaravelComponents\Console\Commands\MakeCommands\MakeServiceCommand;
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
                MakeRepositoryCommand::class,
                MakeSearchCommand::class,
                MakeServiceCommand::class,
                MakeCrudCommand::class,
            ]);
        }
    }
}
