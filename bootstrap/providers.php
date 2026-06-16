<?php

use App\Providers\AppServiceProvider;
use App\Providers\RepositoryServiceProvider;
use App\Providers\BookServiceProvider;
use App\Providers\FortifyServiceProvider;

return [
    FortifyServiceProvider::class,
    AppServiceProvider::class,
    RepositoryServiceProvider::class,
    BookServiceProvider::class,
];
