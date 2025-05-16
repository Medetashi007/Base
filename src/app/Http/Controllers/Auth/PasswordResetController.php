<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\PasswordResetService;
use Illuminate\Http\RedirectResponse;

class PasswordResetController extends Controller
{
    protected PasswordResetService $passwordResetService;

    public function __construct(PasswordResetService $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }

    /**
     * パスワードリセットリンクの送信処理
     *
     * @param ForgotPasswordRequest $request
     * @return RedirectResponse
     */
    public function sendResetLink(ForgotPasswordRequest $request): RedirectResponse
    {
        try {
            $email = $request->input('email');
            $this->passwordResetService->sendResetLink($email);

            return redirect()->back()
                ->with('success', 'パスワードリセットリンクをメールで送信しました。');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->with('error', $e->getMessage());
        }
    }

    /**
     * パスワードリセット処理
     *
     * @param ResetPasswordRequest $request
     * @return RedirectResponse
     */
    public function reset(ResetPasswordRequest $request): RedirectResponse
    {
        try {
            $credentials = $request->only('email', 'password', 'password_confirmation', 'token');
            $this->passwordResetService->resetPassword($credentials);

            return redirect()->route('login')
                ->with('success', 'パスワードが正常にリセットされました。新しいパスワードでログインしてください。');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->with('error', $e->getMessage());
        }
    }
}