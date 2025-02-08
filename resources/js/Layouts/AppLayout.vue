<template>
    <AuthenticatedLayout :auth="auth">
        <slot />
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    auth: {
        type: Object,
        required: true
    }
});
</script>
