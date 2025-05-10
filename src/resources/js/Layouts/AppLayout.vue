<template>
    <div>

        <Head>
            <title>{{ title }} - {{ appName }}</title>
            <meta name="description" content="Laravel + Vue + Inertia SPA アプリケーション" />
        </Head>

        <slot />
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'

// プロップス
const props = defineProps({
    title: {
        type: String,
        default: 'ページ',
    },
})

// アプリケーション名
const appName = 'Laravel SPA'
</script>