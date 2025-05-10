<template>
    <div class="max-w-md mx-auto mt-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4">パスワード変更</h2>

            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        現在のパスワード
                    </label>
                    <input v-model="form.current_password" type="password"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                    <span v-if="form.errors.current_password" class="text-red-500 text-sm">{{
                        form.errors.current_password }}</span>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        新しいパスワード
                    </label>
                    <input v-model="form.password" type="password"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                    <span v-if="form.errors.password" class="text-red-500 text-sm">{{ form.errors.password }}</span>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        新しいパスワード確認
                    </label>
                    <input v-model="form.password_confirmation" type="password"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                </div>

                <button type="submit" :disabled="form.processing"
                    class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 disabled:opacity-50">
                    {{ form.processing ? '処理中...' : 'パスワードを変更' }}
                </button>
            </form>

            <div class="mt-4 text-center">
                <Link :href="route('dashboard')" class="text-blue-500 text-sm">ダッシュボードに戻る</Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
})

function submit() {
    form.post(route('password.change'))
}
</script>