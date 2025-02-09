<script setup>
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';

defineProps({
    auth: {
        type: Object,
        required: true
    }
});

const tabs = ref(['Overview', 'Audiences', 'Demographics', 'More']);
const activeTab = ref('Overview');
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout :auth="auth" title="Dashboard">
        <template #header>
            <h2 class="text-2xl font-bold text-[var(--text-primary)]">
                Dashboard
            </h2>
        </template>

        <!-- Tab Navigation -->
        <div class="mb-6 border-b border-gray-800">
            <div class="flex space-x-8">
                <button
                    v-for="tab in tabs"
                    :key="tab"
                    @click="activeTab = tab"
                    :class="[
                        'py-4 text-sm font-medium border-b-2 -mb-px transition-colors',
                        activeTab === tab
                            ? 'text-blue-500 border-blue-500'
                            : 'text-gray-400 border-transparent hover:text-gray-300'
                    ]"
                >
                    {{ tab }}
                </button>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Bounce Rate -->
            <div class="bg-gray-800/50 rounded-lg p-6">
                <h3 class="text-sm font-medium text-gray-400 mb-2">Bounce Rate</h3>
                <div class="flex items-center">
                    <span class="text-2xl font-semibold text-white">32.53%</span>
                    <span class="ml-2 text-sm text-red-500">-0.5%</span>
                </div>
            </div>

            <!-- Page Views -->
            <div class="bg-gray-800/50 rounded-lg p-6">
                <h3 class="text-sm font-medium text-gray-400 mb-2">Page Views</h3>
                <div class="flex items-center">
                    <span class="text-2xl font-semibold text-white">7,682</span>
                    <span class="ml-2 text-sm text-green-500">+0.3%</span>
                </div>
            </div>

            <!-- New Sessions -->
            <div class="bg-gray-800/50 rounded-lg p-6">
                <h3 class="text-sm font-medium text-gray-400 mb-2">New Sessions</h3>
                <div class="flex items-center">
                    <span class="text-2xl font-semibold text-white">68.8</span>
                    <span class="ml-2 text-sm text-red-500">-8.8</span>
                </div>
            </div>

            <!-- Avg Time on Site -->
            <div class="bg-gray-800/50 rounded-lg p-6">
                <h3 class="text-sm font-medium text-gray-400 mb-2">Avg Time on Site</h3>
                <div class="flex items-center">
                    <span class="text-2xl font-semibold text-white">2m:35s</span>
                    <span class="ml-2 text-sm text-green-500">+0.8%</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Performance Line Chart -->
            <div class="lg:col-span-2 bg-gray-800/50 rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-white">Performance Line Chart</h3>
                        <p class="text-sm text-gray-400">Lorem ipsum is simply dummy text of the printing</p>
                    </div>
                </div>
                <div class="h-64 flex items-end justify-between space-x-2">
                    <!-- Placeholder for chart -->
                    <div class="relative flex-1 h-full">
                        <div class="absolute inset-0 flex items-end">
                            <div class="w-full bg-blue-500/20 rounded-lg" style="height: 70%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Summary -->
            <div class="bg-blue-600 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-white mb-4">Status Summary</h3>
                <div class="text-3xl font-bold text-white mb-4">357</div>
                <div class="flex justify-between items-center">
                    <div>
                        <div class="text-sm font-medium text-blue-200">Total Visitors</div>
                        <div class="text-2xl font-semibold text-white">26.80%</div>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-blue-200">Visits per day</div>
                        <div class="text-2xl font-semibold text-white">9065</div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
