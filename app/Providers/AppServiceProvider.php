<?php

namespace App\Providers;

use App\Repositories\ConfirmationRepository;
use App\Repositories\ConfirmationTypeRepository;
use App\Repositories\DefaultSettingRepository;
use App\Repositories\Interfaces\ConfirmationRepositoryInterface;
use App\Repositories\Interfaces\ConfirmationTypeRepositoryInterface;
use App\Repositories\Interfaces\DefaultSettingRepositoryInterface;
use App\Repositories\Interfaces\SettingRepositoryInterface;
use App\Repositories\Interfaces\SourceRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\UserSettingRepositoryInterface;
use App\Repositories\SettingRepository;
use App\Repositories\SourceRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserSettingRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Lorisleiva\Actions\Facades\Actions;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @var class-string[]
     */
    public $bindings = [
        DefaultSettingRepositoryInterface::class => DefaultSettingRepository::class,
        SettingRepositoryInterface::class => SettingRepository::class,
        UserSettingRepositoryInterface::class => UserSettingRepository::class,
        UserRepositoryInterface::class => UserRepository::class,
        ConfirmationRepositoryInterface::class => ConfirmationRepository::class,

        ConfirmationTypeRepositoryInterface::class => ConfirmationTypeRepository::class,
        SourceRepositoryInterface::class => SourceRepository::class,
    ];

    /**
     * @return void
     */
    public function register(): void
    {
        Model::shouldBeStrict();
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency:3);

        if ($this->app->runningInConsole()) {
            Actions::registerCommands();
        }
    }
}
