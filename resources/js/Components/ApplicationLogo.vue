<script setup>
const props = defineProps({
    class: String,
    src: {
        type: String,
        default: "/storage/logo.png", // fallback logo path
    },
});
</script>

<template>
    <div :class="class">
        <img
            :src="src"
            :alt="'Application Logo'"
            class="h-full w-full object-contain"
            @error="$event.target.src = '/assets/logo-default.svg'"
        />
    </div>
</template>
