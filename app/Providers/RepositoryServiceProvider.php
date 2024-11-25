<?php

namespace App\Providers;

use App\Repository\Eloquents\BaseRepository;
use App\Repository\Eloquents\UserRepository;
use App\Repository\Interfaces\EloquentRepositoryInterface;
use App\Repository\Interfaces\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;


class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    public function boot()
    {

    }
}
