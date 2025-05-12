<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-lg rounded-lg p-8">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">
                        新しいパスワードの設定
                    </h2>
                    <p class="text-sm text-gray-600 text-center">
                        新しいパスワードを入力してください。
                    </p>
                </div>

                <!-- エラーメッセージ -->
                <div v-if="$page.props.flash.error"
                    class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ $page.props.flash.error }}
                </div>

                <form @submit.prevent="submit">
                    <!-- メールアドレス（隠しフィールド） -->
                    <input type="hidden" v-model="form.email">
                    <input type="hidden" v-model="form.token">

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            メールアドレス
                        </label>
                        <input id="email" v-model="form.email" type="email"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100"
                            :class="{ 'border-red-500': form.errors.email }" readonly>
                        <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">
                            {{ form.errors.email }}
                        </p>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            新しいパスワード
                        </label>
                        <input id="password" v-model="form.password" type="password"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            :class="{ 'border-red-500': form.errors.password }" required>
                        <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">
                            {{ form.errors.password }}
                        </p>
                    </div>

                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            パスワード確認
                        </label>
                        <input id="password_confirmation" v-model="form.password_confirmation" type="password"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>

                    <button type="submit" :disabled="form.processing"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                        {{ form.processing ? '更新中...' : 'パスワードをリセット' }}
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

// Props
const props = defineProps({
    token: {
        type: String,
        required: true
    },
    email: {
        type: String,
        required: true
    }
})

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
})

function submit() {
    form.post(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => {
            // 成功時は自動でログインページにリダイレクト
        },
        onError: (errors) => {
            console.log('エラー:', errors)
        }
    })
}
</script>