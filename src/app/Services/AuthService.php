<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * ユーザー新規登録
     *
     * @param array $data
     * @return User
     */
    public function register(array $data): User
    {
        try {
            // パスワードをハッシュ化
            $data['password'] = Hash::make($data['password']);

            // ユーザー作成
            $user = User::create($data);

            // 自動ログイン
            Auth::login($user);

            Log::info('User registered successfully', ['user_id' => $user->id]);

            return $user;
        } catch (\Exception $e) {
            Log::error('User registration failed', [
                'error' => $e->getMessage(),
                'data' => array_merge($data, ['password' => '[HIDDEN]'])
            ]);

            throw $e;
        }
    }

    /**
     * ログイン処理
     *
     * @param array $credentials
     * @param bool $remember
     * @return bool
     * @throws ValidationException
     */
    public function login(array $credentials, bool $remember = false): bool
    {
        try {
            // 認証試行
            if (Auth::attempt($credentials, $remember)) {
                Log::info('User logged in successfully', [
                    'user_id' => auth()->id(),
                    'email' => auth()->user()->email
                ]);

                return true;
            }

            // ログイン失敗のログ
            Log::warning('Login attempt failed', [
                'email' => $credentials['email']
            ]);

            // ログイン失敗時のエラー
            throw ValidationException::withMessages([
                'email' => 'メールアドレスまたはパスワードが正しくありません。',
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Login process failed', [
                'error' => $e->getMessage(),
                'email' => $credentials['email'] ?? null
            ]);

            throw $e;
        }
    }

    /**
     * ログアウト処理
     *
     * @return void
     */
    public function logout(): void
    {
        $userId = auth()->id();

        try {
            // ログアウト実行
            Auth::logout();

            // セッション無効化とCSRFトークンの再生成
            session()->invalidate();
            session()->regenerateToken();

            Log::info('User logged out successfully', ['user_id' => $userId]);
        } catch (\Exception $e) {
            Log::error('Logout failed', [
                'error' => $e->getMessage(),
                'user_id' => $userId
            ]);

            throw $e;
        }
    }

    /**
     * ユーザーの認証状態チェック
     *
     * @return User|null
     */
    public function getCurrentUser(): ?User
    {
        return auth()->user();
    }

    /**
     * パスワード変更
     *
     * @param int $userId
     * @param string $currentPassword
     * @param string $newPassword
     * @return bool
     * @throws ValidationException
     */
    public function changePassword(int $userId, string $currentPassword, string $newPassword): bool
    {
        try {
            $user = User::findOrFail($userId);

            // 現在のパスワードを確認
            if (!Hash::check($currentPassword, $user->password)) {
                throw ValidationException::withMessages([
                    'current_password' => '現在のパスワードが正しくありません。',
                ]);
            }

            // 新しいパスワードに更新
            $user->password = Hash::make($newPassword);
            $user->save();

            Log::info('Password changed successfully', ['user_id' => $userId]);

            return true;
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Password change failed', [
                'error' => $e->getMessage(),
                'user_id' => $userId
            ]);

            throw $e;
        }
    }
}