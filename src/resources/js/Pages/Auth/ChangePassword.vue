<template>
    <div class="min-h-screen bg-gray-100">
        <!-- ナビゲーションバー -->
        <nav class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <h1 class="text-lg font-semibold text-gray-900">パスワード変更</h1>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <Link :href="route('dashboard')"
                            class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        ダッシュボードに戻る
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <!-- メインコンテンツ -->
        <main class="max-w-md mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        パスワードの変更
                    </h3>

                    <!-- エラーメッセージ -->
                    <div v-if="$page.props.flash.error" class="mb-4 rounded-md bg-red-50 p-4">
                        <div class="text-sm text-red-700">
                            {{ $page.props.flash.error }}
                        </div>
                    </div>

                    <form @submit.prevent="handleChangePassword" class="space-y-4">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700">
                                現在のパスワード
                            </label>
                            <input id="current_password" v-model="form.current_password" type="password" required
                                class="mt-1 appearance-none relative block w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                :class="errors.current_password ? 'border-red-300' : 'border-gray-300'" />
                            <div v-if="errors.current_password" class="text-red-500 text-xs mt-1">
                                {{ errors.current_password }}
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                新しいパスワード
                            </label>
                            <input id="password" v-model="form.password" type="password" required
                                class="mt-1 appearance-none relative block w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                :class="errors.password ? 'border-red-300' : 'border-gray-300'" minlength="8"
                                maxlength="10" />
                            <div v-if="errors.password" class="text-red-500 text-xs mt-1">
                                {{ errors.password }}
                            </div>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                新しいパスワード（確認）
                            </label>
                            <input id="password_confirmation" v-model="form.password_confirmation" type="password"
                                required
                                class="mt-1 appearance-none relative block w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                :class="errors.password_confirmation ? 'border-red-300' : 'border-gray-300'"
                                minlength="8" maxlength="10" />
                            <div v-if="errors.password_confirmation" class="text-red-500 text-xs mt-1">
                                {{ errors.password_confirmation }}
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" :disabled="form.processing"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50">
                                <span v-if="form.processing">変更中...</span>
                                <span v-else>パスワードを変更</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
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
    current_password: '',
    password: '',
    password_confirmation: '',
})

// パスワード変更処理
const handleChangePassword = () => {
    form.put(route('password.change'), {
        onError: () => {
            // パスワードフィールドをクリア
            form.current_password = ''
            form.password = ''
            form.password_confirmation = ''
        },
    })
}
</script>