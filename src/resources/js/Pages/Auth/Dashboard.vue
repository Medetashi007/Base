<template>
    <div class="min-h-screen bg-gray-100">
        <!-- ナビゲーションバー -->
        <nav class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <h1 class="text-lg font-semibold text-gray-900">ダッシュボード</h1>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-700">
                            {{ user.username }}さん
                        </span>
                        <button @click="handleLogout"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            ログアウト
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- メインコンテンツ -->
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <!-- 成功メッセージ -->
            <div v-if="$page.props.flash.success" class="mb-4 rounded-md bg-green-50 p-4">
                <div class="text-sm text-green-700">
                    {{ $page.props.flash.success }}
                </div>
            </div>

            <div class="px-4 py-6 sm:px-0">
                <div class="border-4 border-dashed border-gray-200 rounded-lg p-4">
                    <div class="text-center">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">
                            ようこそ、{{ user.username }}さん！
                        </h2>
                        <p class="text-gray-600 mb-6">
                            ダッシュボードへのアクセスに成功しました。
                        </p>

                        <!-- ユーザー情報カード -->
                        <div class="bg-white shadow overflow-hidden sm:rounded-md max-w-md mx-auto">
                            <ul class="divide-y divide-gray-200">
                                <li class="px-6 py-4 sm:px-6">
                                    <div class="flex justify-between">
                                        <p class="text-sm font-medium text-gray-900">ユーザー名</p>
                                        <p class="text-sm text-gray-500">{{ user.username }}</p>
                                    </div>
                                </li>
                                <li class="px-6 py-4 sm:px-6">
                                    <div class="flex justify-between">
                                        <p class="text-sm font-medium text-gray-900">メールアドレス</p>
                                        <p class="text-sm text-gray-500">{{ user.email }}</p>
                                    </div>
                                </li>
                                <li class="px-6 py-4 sm:px-6">
                                    <div class="flex justify-between">
                                        <p class="text-sm font-medium text-gray-900">ユーザーID</p>
                                        <p class="text-sm text-gray-500">{{ user.id }}</p>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- 追加機能ボタン -->
                        <div class="mt-8 space-x-4">
                            <Link :href="route('password.change')"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            パスワード変更
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import { useForm, Link, router } from '@inertiajs/vue3'

// ページのプロップス
const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
})

// ログアウト処理
const handleLogout = () => {
    router.post(route('logout'))
}
</script>