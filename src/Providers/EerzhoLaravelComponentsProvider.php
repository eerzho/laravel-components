<?php

namespace Eerzho\LaravelComponents\Providers;

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
            ]);
        }
    }
}
