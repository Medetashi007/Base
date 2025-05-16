<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
        <div class="flex min-h-screen items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="w-full max-w-md space-y-8">
                <!-- ヘッダー -->
                <div class="text-center">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900">
                        Welcome
                    </h1>
                    <p class="mt-2 text-sm text-gray-600">
                        アカウントへのアクセス方法を選択してください
                    </p>
                </div>

                <!-- 認証オプション -->
                <div class="mt-8 space-y-4">
                    <div v-for="option in authOptions" :key="option.label" @click="navigateTo(option.route)"
                        class="p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 cursor-pointer border border-gray-200 hover:border-indigo-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">
                                    {{ option.label }}
                                </h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    {{ option.description }}
                                </p>
                            </div>
                            <div>
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- フッター情報 -->
                <div class="mt-8 text-center">
                    <p class="text-xs text-gray-500">
                        このアプリケーションを利用することで、利用規約とプライバシーポリシーに同意したものとみなされます。
                    </p>
                </div>
            </div>
        </div>

        <!-- 背景装飾 -->
        <div class="fixed inset-0 -z-10 overflow-hidden">
            <div class="absolute -top-40 -left-40 h-80 w-80 rounded-full bg-indigo-200 opacity-50 blur-3xl"></div>
            <div class="absolute -bottom-40 -right-40 h-80 w-80 rounded-full bg-blue-200 opacity-50 blur-3xl"></div>
        </div>
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'

// Props
const props = defineProps({
    authOptions: {
        type: Object,
        required: true,
        default: () => ({})
    }
})

// Methods
const navigateTo = (route) => {
    router.visit(route)
}
</script>

<style scoped>
/* 追加のスタイルが必要な場合はここに */
</style>