<template>
    <div class="min-h-screen bg-gray-100">
        <!-- ナビゲーションバー -->
        <nav v-if="$page.props.auth.user" class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <Link :href="route('dashboard')" class="text-xl font-semibold text-gray-900">
                        MyApp
                        </Link>
                    </div>

                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700">{{ $page.props.auth.user.username }}さん</span>
                        <Link :href="route('logout')" method="post" as="button" class="text-red-600 hover:text-red-800">
                        ログアウト
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <!-- フラッシュメッセージ -->
        <div v-if="$page.props.flash?.success" class="bg-green-500 text-white p-4 text-center">
            {{ $page.props.flash.success }}
        </div>
        <div v-if="$page.props.flash?.error" class="bg-red-500 text-white p-4 text-center">
            {{ $page.props.flash.error }}
        </div>

        <!-- メインコンテンツ -->
        <main class="py-8">
            <slot />
        </main>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>