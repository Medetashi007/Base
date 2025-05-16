<template>
    <div class="max-w-md mx-auto mt-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4">ログイン</h2>

            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        メールアドレス
                    </label>
                    <input v-model="form.email" type="email"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                    <span v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</span>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        パスワード
                    </label>
                    <input v-model="form.password" type="password"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                    <span v-if="form.errors.password" class="text-red-500 text-sm">{{ form.errors.password }}</span>
                </div>

                <div class="mb-4">
                    <label class="flex items-center">
                        <input v-model="form.remember" type="checkbox" class="mr-2">
                        <span class="text-sm text-gray-700">ログイン状態を保持する</span>
                    </label>
                </div>

                <button type="submit" :disabled="form.processing"
                    class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 disabled:opacity-50">
                    {{ form.processing ? '処理中...' : 'ログイン' }}
                </button>
            </form>

            <div class="mt-4 text-center">
                <Link :href="route('register.form')" class="text-blue-500 text-sm">新規登録はこちら</Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'

const form = useForm({
    email: '',
    password: '',
    remember: false,
})

function submit() {
    form.post(route('login'))
}
</script>