<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Inertia\Response;
use Inertia\Inertia;

class AuthLandingController extends Controller
{
    /**
     * 認証ランディングページを表示
     * ログイン、新規登録、パスワード忘れへのアクセスを提供
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Auth/Landing', [
            'authOptions' => [
                'login' => [
                    'label' => 'ログイン',
                    'description' => '既にアカウントをお持ちの方',
                    'route' => route('login'),
                ],
                'register' => [
                    'label' => '新規登録',
                    'description' => '初めての方はこちら',
                    'route' => route('register.form'),
                ],
                'forgotPassword' => [
                    'label' => 'パスワードを忘れた方',
                    'description' => 'パスワードリセットはこちら',
                    'route' => route('password.request'),
                ],
            ],
        ]);
    }
}