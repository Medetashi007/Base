<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    ログイン
                </h2>
            </div>

            <!-- エラーメッセージ -->
            <div v-if="$page.props.flash.error" class="rounded-md bg-red-50 p-4">
                <div class="text-sm text-red-700">
                    {{ $page.props.flash.error }}
                </div>
            </div>

            <!-- 成功メッセージ -->
            <div v-if="$page.props.flash.success" class="rounded-md bg-green-50 p-4">
                <div class="text-sm text-green-700">
                    {{ $page.props.flash.success }}
                </div>
            </div>

            <form @submit.prevent="handleLogin" class="mt-8 space-y-6">
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="email" class="sr-only">メールアドレス</label>
                        <input id="email" v-model="form.email" type="email" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border"
                            :class="errors.email ? 'border-red-300' : 'border-gray-300'" placeholder="メールアドレス" />
                        <div v-if="errors.email" class="text-red-500 text-xs mt-1">
                            {{ errors.email }}
                        </div>
                    </div>
                    <div>
                        <label for="password" class="sr-only">パスワード</label>
                        <input id="password" v-model="form.password" type="password" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border"
                            :class="errors.password ? 'border-red-300' : 'border-gray-300'" placeholder="パスワード" />
                        <input type="hidden" :value="form._token" name="_token">
                        <div v-if="errors.password" class="text-red-500 text-xs mt-1">
                            {{ errors.password }}
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" v-model="form.remember" type="checkbox"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" />
                        <label for="remember" class="ml-2 block text-sm text-gray-900">
                            ログイン状態を保持
                        </label>
                    </div>
                </div>

                <div>
                    <button type="submit" :disabled="form.processing"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50">
                        <span v-if="form.processing">処理中...</span>
                        <span v-else>ログイン</span>
                    </button>
                </div>

                <div class="text-sm text-center">
                    <Link :href="route('register')" class="font-medium text-indigo-600 hover:text-indigo-500">
                    アカウントをお持ちでない方はこちら
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
    email: '',
    password: '',
    remember: false,
})

// ログイン処理
const handleLogin = () => {
    form.post(route('login.post'), {
        onError: () => {
            // パスワードフィールドをクリア
            form.password = ''
        },
    })
}
</script>