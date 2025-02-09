<script setup>
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    auth: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout :auth="auth">
        <template #header>
            <h2 class="text-2xl font-bold text-[var(--text-primary)]">
                Dashboard
            </h2>
        </template>
    </AuthenticatedLayout>
</template>
