<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    新規登録
                </h2>
            </div>

            <!-- エラーメッセージ -->
            <div v-if="$page.props.flash.error" class="rounded-md bg-red-50 p-4">
                <div class="text-sm text-red-700">
                    {{ $page.props.flash.error }}
                </div>
            </div>

            <form @submit.prevent="handleRegister" class="mt-8 space-y-6">
                <div class="rounded-md shadow-sm space-y-4">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">
                            ユーザー名
                        </label>
                        <input id="username" v-model="form.username" type="text" required
                            class="mt-1 appearance-none relative block w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            :class="errors.username ? 'border-red-300' : 'border-gray-300'" placeholder="ユーザー名（10文字以内）"
                            maxlength="10" />
                        <div v-if="errors.username" class="text-red-500 text-xs mt-1">
                            {{ errors.username }}
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            メールアドレス
                        </label>
                        <input id="email" v-model="form.email" type="email" required
                            class="mt-1 appearance-none relative block w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            :class="errors.email ? 'border-red-300' : 'border-gray-300'" placeholder="メールアドレス（50文字以内）"
                            maxlength="50" />
                        <div v-if="errors.email" class="text-red-500 text-xs mt-1">
                            {{ errors.email }}
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            パスワード
                        </label>
                        <input id="password" v-model="form.password" type="password" required
                            class="mt-1 appearance-none relative block w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            :class="errors.password ? 'border-red-300' : 'border-gray-300'" placeholder="パスワード（8-10文字）"
                            minlength="8" maxlength="10" />
                        <div v-if="errors.password" class="text-red-500 text-xs mt-1">
                            {{ errors.password }}
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                            パスワード確認
                        </label>
                        <input id="password_confirmation" v-model="form.password_confirmation" type="password" required
                            class="mt-1 appearance-none relative block w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            :class="errors.password_confirmation ? 'border-red-300' : 'border-gray-300'"
                            placeholder="パスワードを再入力" minlength="8" maxlength="10" />
                        <div v-if="errors.password_confirmation" class="text-red-500 text-xs mt-1">
                            {{ errors.password_confirmation }}
                        </div>
                    </div>
                </div>

                <div>
                    <button type="submit" :disabled="form.processing"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50">
                        <span v-if="form.processing">処理中...</span>
                        <span v-else>アカウントを作成</span>
                    </button>
                </div>

                <div class="text-sm text-center">
                    <Link :href="route('login')" class="font-medium text-indigo-600 hover:text-indigo-500">
                    既にアカウントをお持ちの方はこちら
                    </Link>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3'

// ページのメタデータ
defineProps({
    errors: Object,
})

// フォームの初期化
const form = useForm({
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
})

// 新規登録処理
const handleRegister = () => {
    form.post(route('register.post'), {
        onError: () => {
            // パスワードフィールドをクリア
            form.password = ''
            form.password_confirmation = ''
        },
    })
}
</script>