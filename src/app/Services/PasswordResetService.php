<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PasswordResetService
{
    /**
     * パスワードリセットリンクの送信
     *
     * @param string $email
     * @return string
     * @throws ValidationException
     */
    public function sendResetLink(string $email): string
    {
        try {
            // 該当ユーザーの存在チェック
            $user = User::where('email', $email)->first();
            
            if (!$user) {
                // セキュリティのため、ユーザーが存在しない場合も成功したようにレスポンス
                Log::info('Password reset link requested for non-existent email', ['email' => $email]);
                return 'reset_link_sent';
            }

            // リセットリンクの送信
            $status = Password::sendResetLink(['email' => $email]);

            if ($status === Password::RESET_LINK_SENT) {
                Log::info('Password reset link sent successfully', ['email' => $email]);
                return 'reset_link_sent';
            }

            // 送信失敗の場合
            if ($status === Password::RESET_THROTTLED) {
                throw ValidationException::withMessages([
                    'email' => 'しばらくお待ちいただいてから再度お試しください。',
                ]);
            }

            throw ValidationException::withMessages([
                'email' => 'パスワードリセットリンクの送信に失敗しました。',
            ]);

        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Password reset link sending failed', [
                'error' => $e->getMessage(),
                'email' => $email
            ]);

            throw new \Exception('パスワードリセットの処理中にエラーが発生しました。');
        }
    }

    /**
     * パスワードの再設定
     *
     * @param array $credentials
     * @return string
     * @throws ValidationException
     */
    public function resetPassword(array $credentials): string
    {
        try {
            // パスワードのリセット処理
            $status = Password::reset($credentials, function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                Log::info('Password reset successfully', ['user_id' => $user->id]);
            });

            // リセット結果の処理
            if ($status === Password::PASSWORD_RESET) {
                return 'password_reset';
            }

            // エラーハンドリング
            $errorMessages = [
                Password::INVALID_TOKEN => 'リセットリンクが無効です。再度パスワードリセットをお申し込みください。',
                Password::INVALID_USER => 'このメールアドレスに該当するユーザーが見つかりません。',
                Password::PASSWORD_RESET => 'パスワードが正常にリセットされました。',
            ];

            throw ValidationException::withMessages([
                'email' => $errorMessages[$status] ?? 'パスワードリセットに失敗しました。',
            ]);

        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Password reset failed', [
                'error' => $e->getMessage(),
                'email' => $credentials['email'] ?? null
            ]);

            throw new \Exception('パスワードリセットの処理中にエラーが発生しました。');
        }
    }
}