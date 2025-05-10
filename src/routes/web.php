<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// テスト用のシンプルなルート
Route::get('/test', function () {
    return Inertia::render('Test');
});

// 公開ルート
Route::middleware('guest')->group(function () {
    // ログインページ
    Route::get('/login', function () {
        return Inertia::render('Auth/Login');
    })->name('login');

    // 新規登録ページ
    Route::get('/register', function () {
        return Inertia::render('Auth/Register');
    })->name('register');

    // ログイン処理
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // 新規登録処理
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// 認証が必要なルート
Route::middleware('auth')->group(function () {
    // ダッシュボード
    Route::get('/dashboard', function () {
        return Inertia::render('Auth/Dashboard', [
            'user' => auth()->user()
        ]);
    })->name('dashboard');

    // ログアウト処理
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // パスワード変更
    Route::get('/password/change', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::put('/password/change', [AuthController::class, 'changePassword'])->name('password.change.post');

    // その他の認証が必要なルート
    // Route::get('/profile', ...);
});

// ルートページ（未認証なら/loginへ、認証済みなら/dashboardへ）
Route::get('/', function () {
    return redirect(auth()->check() ? '/dashboard' : '/login');
})->name('home');