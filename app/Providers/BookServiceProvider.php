<?php

namespace App\Providers;

use App\Services\BookService;
use App\Services\Contracts\BookServiceInterface;
use Illuminate\Support\ServiceProvider;

class BookServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(BookServiceInterface::class, BookService::class);
    }
}
