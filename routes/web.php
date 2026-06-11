<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', fn () => view('admin.index', [
    'title' => 'Tổng quan',
    'header' => 'Tổng quan',
]))->name('admin.dashboard');

Route::get('/admin/book/list', [App\Http\Controllers\BookController::class, 'list'])->name('admin.book.list');
