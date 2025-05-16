<template>
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">ダッシュボード</h1>

            <p class="text-gray-600 mb-4">
                {{ user.username }}さん、おかえりなさい！
            </p>

            <div class="flex space-x-4">
                <Link :href="route('password.change.form')"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                パスワード変更
                </Link>

                <Link :href="route('logout')" method="post" as="button"
                    class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                ログアウト
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    user: Object,
    data: Object,
})
</script>