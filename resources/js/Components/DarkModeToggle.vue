<script setup>
import { ref, onMounted, watch } from 'vue';
import { SunIcon, MoonIcon } from '@heroicons/vue/24/solid';

const isDark = ref(false);

// Fungsi untuk mengupdate tema
const updateTheme = (dark) => {
    if (dark) {
        document.documentElement.classList.add('dark');
        document.documentElement.style.colorScheme = 'dark';
        localStorage.theme = 'dark';
    } else {
        document.documentElement.classList.remove('dark');
        document.documentElement.style.colorScheme = 'light';
        localStorage.theme = 'light';
    }
};

// Watch perubahan isDark
watch(isDark, (newValue) => {
    updateTheme(newValue);
});

onMounted(() => {
    // Check sistem preferensi dan localStorage
    const darkMode = localStorage.theme === 'dark' || 
        (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
    
    isDark.value = darkMode;
    updateTheme(darkMode);

    // Listen untuk perubahan preferensi sistem
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        if (!localStorage.theme) { // Hanya update jika user belum set preferensi
            isDark.value = e.matches;
        }
    });
});

const toggleDarkMode = () => {
    isDark.value = !isDark.value;
};
</script>

<template>
    <div class="fixed bottom-6 right-6 z-50">
        <button
            @click="toggleDarkMode"
            class="p-3 rounded-full bg-[var(--bg-secondary)]/80 backdrop-blur-lg shadow-lg border border-[var(--border-primary)] hover:scale-110 transition-all duration-300 group"
            :class="{ 'rotate-[360deg]': isDark }"
        >
            <SunIcon v-if="!isDark" class="w-6 h-6 text-[var(--warning-500)] group-hover:text-[var(--warning-600)] transition-colors" />
            <MoonIcon v-else class="w-6 h-6 text-[var(--primary-500)] group-hover:text-[var(--primary-600)] transition-colors" />
            
            <!-- Tooltip -->
            <span class="absolute right-full mr-2 top-1/2 -translate-y-1/2 px-2 py-1 text-xs rounded-md bg-[var(--bg-secondary)] border border-[var(--border-primary)] text-[var(--text-secondary)] whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity">
                {{ isDark ? 'Beralih ke Mode Terang' : 'Beralih ke Mode Gelap' }}
            </span>
        </button>
    </div>
</template>

<style>
/* Transisi global untuk perubahan warna */
:root {
    transition: color-scheme 0.3s ease;
}

html.dark {
    color-scheme: dark;
}

button {
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}
</style> 