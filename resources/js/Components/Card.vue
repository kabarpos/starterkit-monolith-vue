<script setup>
defineProps({
    variant: {
        type: String,
        default: 'default', // 'default', 'primary', 'success', 'warning', 'danger'
    },
    hover: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <div 
        :class="[
            'bg-[var(--card-gradient)] backdrop-blur-lg rounded-xl shadow-sm transition-all duration-300',
            'border',
            // Variants
            variant === 'default' && [
                'border-[var(--border-primary)]',
                hover && 'hover:border-[var(--primary-400)] hover:shadow-md hover:scale-[1.02]'
            ],
            variant === 'primary' && [
                'bg-gradient-to-br from-[var(--primary-600)] to-[var(--accent-600)] text-white',
                'border-transparent',
                hover && 'hover:shadow-lg hover:scale-[1.02]'
            ],
            variant === 'success' && [
                'bg-gradient-to-br from-[var(--success-500)] to-[var(--success-600)] text-white',
                'border-transparent',
                hover && 'hover:shadow-lg hover:scale-[1.02]'
            ],
            variant === 'warning' && [
                'bg-gradient-to-br from-[var(--warning-500)] to-[var(--warning-600)] text-white',
                'border-transparent',
                hover && 'hover:shadow-lg hover:scale-[1.02]'
            ],
            variant === 'danger' && [
                'bg-gradient-to-br from-[var(--error-500)] to-[var(--error-600)] text-white',
                'border-transparent',
                hover && 'hover:shadow-lg hover:scale-[1.02]'
            ],
            // Hover Effect
            hover && 'cursor-pointer'
        ]"
    >
        <div class="p-6">
            <slot />
        </div>
    </div>
</template> 