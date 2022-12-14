<?php

namespace App\Providers;

use App\Http\Controllers\TodoController;
use App\Repository\Contracts\TodoRepoInterface;
use App\Repository\TodoRepo;
use App\Usecase\Contracts\TodoUsecaseInterface;
use App\Usecase\TodoUsecase;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class TodoServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(TodoRepoInterface::class, TodoRepo::class);
        $this->app->bind(TodoUsecaseInterface::class, TodoUsecase::class);
        $this->app->bind(TodoController::class, function ($app) {
            return new TodoController($app->make(TodoUsecaseInterface::class));
        });
        return;
    }
}
