<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\AuthViewController;
use App\Http\Controllers\Auth\AuthLandingController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

/**
 * ルートページ - 認証ランディングページ（ログイン/登録/パスワードリセットへの案内）
 */
Route::get('/', [AuthLandingController::class, 'index'])->name('welcome');

/**
 * 認証関連のルートグループ
 */
Route::prefix('auth')->group(function () {
    
    // ゲスト用ルート（未認証ユーザー向け）
    Route::middleware('guest')->group(function () {
        // フォーム表示
        Route::get('/login', [AuthViewController::class, 'showLogin'])->name('login');
        Route::get('/register', [AuthViewController::class, 'showRegister'])->name('register.form');
        Route::get('/forgot-password', [AuthViewController::class, 'showForgotPassword'])->name('password.request');
        Route::get('/reset-password/{token}', [AuthViewController::class, 'showResetPassword'])->name('password.reset');
        
        // 処理
        Route::post('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    });

    // 認証済みユーザー用ルート
    Route::middleware('auth')->group(function () {
        // フォーム表示
        Route::get('/change-password', [AuthViewController::class, 'showChangePassword'])->name('password.change.form');
        
        // 処理
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('/change-password', [AuthController::class, 'changePassword'])->name('password.change');
        
        // API用認証チェック
        Route::get('/check', [AuthController::class, 'checkAuth'])->name('auth.check');
    });
});

/**
 * アプリケーションのメインルート（認証済みユーザー用）
 */
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // 他の認証が必要なルートをここに追加
});

/**
 * その他のルート
 */
Route::middleware('auth')->group(function () {
    // ヘルスチェックやメンテナンス用のルートなど
});