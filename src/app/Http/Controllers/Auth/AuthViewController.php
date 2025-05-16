<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class AuthViewController extends Controller
{
    /**
     * ログインフォームを表示
     *
     * @return Response
     */
    public function showLogin(): Response
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * 新規登録フォームを表示
     *
     * @return Response
     */
    public function showRegister(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * パスワード変更フォームを表示
     *
     * @return Response
     */
    public function showChangePassword(): Response
    {
        return Inertia::render('Auth/ChangePassword');
    }

    /**
     * パスワード忘れ申請フォームを表示
     *
     * @return Response
     */
    public function showForgotPassword(): Response
    {
        return Inertia::render('Auth/ForgotPassword');
    }

    /**
     * パスワードリセットフォームを表示
     *
     * @param Request $request
     * @param string $token
     * @return Response
     */
    public function showResetPassword(Request $request, string $token): Response
    {
        return Inertia::render('Auth/ResetPassword', [
            'token' => $token,
            'email' => urldecode($request->query('email')),
        ]);
    }
}