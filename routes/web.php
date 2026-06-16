<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/', fn () => redirect()->route('admin.dashboard'));

Route::middleware('auth')
    ->prefix('admin')
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
                /*
                 * Admin + Audit
                 */
                Route::middleware('role:admin|audit')
                    ->group(function () {

                        Route::get('/list', [BookController::class, 'list'])
                            ->name('list');

                        Route::get('/detail/{id}', [BookController::class, 'detail'])
                            ->name('detail');
                    });

                /*
                 * Admin only
                 */
                Route::middleware('role:admin')
                    ->group(function () {

                        Route::get('/create', [BookController::class, 'create'])
                            ->name('create');

                        Route::post('/store', [BookController::class, 'store'])
                            ->name('store');

                        Route::get('/edit/{id}', [BookController::class, 'edit'])
                            ->name('edit');

                        Route::put('/update/{id}', [BookController::class, 'update'])
                            ->name('update');

                        Route::delete('/delete/{id}', [BookController::class, 'delete'])
                            ->name('delete');
                    });
            });
    });
