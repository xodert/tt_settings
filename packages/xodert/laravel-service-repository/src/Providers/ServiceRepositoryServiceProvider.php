<?php

namespace Xodert\ServiceRepository\Providers;

use Xodert\ServiceRepository\Console\Commands\InitCommand;
use Xodert\ServiceRepository\Console\Commands\RepositoryInterfaceMakeCommand;
use Xodert\ServiceRepository\Console\Commands\RepositoryMakeCommand;
use Xodert\ServiceRepository\Console\Commands\ServiceMakeCommand;
use Illuminate\Support\ServiceProvider;

class ServiceRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/service-repository.php', 'service-repository'
        );

        $this->publishes([
            __DIR__ . '/../../config/service-repository.php' => config_path('service-repository.php')
        ]);

        $this->registerCommand();
    }

    /**
     * @return void
     */
    private function registerCommand(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                RepositoryMakeCommand::class,
                RepositoryInterfaceMakeCommand::class,
                ServiceMakeCommand::class,
                InitCommand::class
            ]);
        }
    }
}
