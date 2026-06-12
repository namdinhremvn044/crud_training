<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get(
            '/',
            fn() => view('admin.index', [
                'title' => 'Tổng quan',
                'header' => 'Tổng quan',
            ]),
        )->name('dashboard');

        Route::prefix('book')
            ->name('book.')
            ->group(function () {
                Route::get('/list', [BookController::class, 'list'])->name('list');
                Route::get('/detail/{id}', [BookController::class, 'detail'])->name('detail');
                Route::get('/create', [BookController::class, 'create'])->name('create');
                Route::post('/store', [BookController::class, 'store'])->name('store');
            });
    });
