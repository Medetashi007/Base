<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-lg rounded-lg p-8">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">
                        パスワード忘れ
                    </h2>
                    <p class="text-sm text-gray-600 text-center">
                        登録時のメールアドレスを入力してください。<br>
                        パスワードリセットリンクを送信します。
                    </p>
                </div>

                <!-- 成功メッセージ -->
                <div v-if="$page.props.flash.success"
                    class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ $page.props.flash.success }}
                </div>

                <!-- エラーメッセージ -->
                <div v-if="$page.props.flash.error"
                    class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ $page.props.flash.error }}
                </div>

                <form @submit.prevent="submit">
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            メールアドレス
                        </label>
                        <input id="email" v-model="form.email" type="email"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            :class="{ 'border-red-500': form.errors.email }" required>
                        <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">
                            {{ form.errors.email }}
                        </p>
                    </div>

                    <button type="submit" :disabled="form.processing"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                        {{ form.processing ? '送信中...' : 'リセットリンクを送信' }}
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <Link :href="route('login')" class="text-sm text-blue-600 hover:text-blue-500">
                    ← ログインページに戻る
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'

const form = useForm({
    email: '',
})

function submit() {
    form.post(route('password.email'), {
        preserveScroll: true,
        onSuccess: () => {
            // フォームをクリアしない（成功メッセージ表示のため）
        },
        onError: (errors) => {
            console.log('エラー:', errors)
        }
    })
}
</script>