<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', fn () => view('admin.index', [
    'title' => 'Tổng quan',
    'header' => 'Tổng quan',
]))->name('admin.dashboard');
