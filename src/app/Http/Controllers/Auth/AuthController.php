<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * 新規登録処理
     *
     * @param RegisterUserRequest $request
     * @return RedirectResponse
     */
    public function register(RegisterUserRequest $request): RedirectResponse
    {
        try {
            $validated = $request->validated();
            $user = $this->authService->register($validated);

            return redirect()->route('dashboard')
                ->with('success', 'アカウントが正常に作成されました。');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput($request->only('username', 'email'))
                ->with('error', '登録処理中にエラーが発生しました。');
        }
    }

    /**
     * ログイン処理
     *
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        try {
            $credentials = $request->only('email', 'password');
            $remember = $request->boolean('remember');

            $this->authService->login($credentials, $remember);

            // セッション再生成でセキュリティを向上
            $request->session()->regenerate();

            // 意図されていたURLがある場合はそこへ、なければダッシュボードへ
            $intended = $request->session()->get('url.intended', route('dashboard'));

            return redirect($intended)
                ->with('success', 'ログインしました。');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->with('error', $e->getMessage());
        }
    }

    /**
     * ログアウト処理
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        try {
            $this->authService->logout();

            return redirect()->route('login')
                ->with('success', 'ログアウトしました。');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'ログアウト処理中にエラーが発生しました。');
        }
    }

    /**
     * ログイン状態のチェック（API用）
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkAuth(): \Illuminate\Http\JsonResponse
    {
        $user = $this->authService->getCurrentUser();

        if ($user) {
            return response()->json([
                'authenticated' => true,
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                ]
            ]);
        }

        return response()->json([
            'authenticated' => false,
            'user' => null
        ]);
    }

    /**
     * パスワード変更フォーム
     *
     * @return Response
     */
    public function showChangePasswordForm(): Response
    {
        return Inertia::render('Auth/ChangePassword');
    }

    /**
     * パスワード変更処理
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function changePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|max:10|confirmed',
        ]);

        try {
            $this->authService->changePassword(
                auth()->id(),
                $request->current_password,
                $request->password
            );

            return redirect()->route('dashboard')
                ->with('success', 'パスワードが正常に変更されました。');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }
}