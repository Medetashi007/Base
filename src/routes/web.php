<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// テスト用のシンプルなルート
Route::get('/', function () {
    return Inertia::render('Test');
});
