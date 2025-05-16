<template>
    <div class="max-w-md mx-auto mt-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4">新規登録</h2>

            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        ユーザー名
                    </label>
                    <input v-model="form.username" type="text"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                    <span v-if="form.errors.username" class="text-red-500 text-sm">{{ form.errors.username }}</span>
                </div>

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
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        パスワード確認
                    </label>
                    <input v-model="form.password_confirmation" type="password"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                </div>

                <button type="submit" :disabled="form.processing"
                    class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 disabled:opacity-50">
                    {{ form.processing ? '処理中...' : '登録' }}
                </button>
            </form>

            <div class="mt-4 text-center">
                <Link :href="route('login')" class="text-blue-500 text-sm">ログインはこちら</Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'

const form = useForm({
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
})

function submit() {
    form.post(route('register'))
}
</script>