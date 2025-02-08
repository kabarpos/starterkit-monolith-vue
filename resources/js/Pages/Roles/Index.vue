<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Manajemen Role</h2>
            </div>
        </template>

        <div class="py-2">
            <div class="max-w-full mx-auto ">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <!-- Search and Filter Section -->
                        <div class="mb-6 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                            <div class="flex-1 max-w-md">
                                <div class="relative">
                                    <input 
                                        v-model="search"
                                        type="text" 
                                        placeholder="Cari role..." 
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 pl-10"
                                        @input="performSearch"
                                    >
                                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <Link 
                                :href="route('admin.roles.create')" 
                                class="inline-flex items-center px-4 py-2 bg-[#0B2447] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#19376D] focus:bg-[#19376D] active:bg-[#19376D] focus:outline-none focus:ring-2 focus:ring-[#19376D] focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Tambah Role Baru
                            </Link>
                        </div>

                        <!-- Roles Table -->
                        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
                            <table class="border-collapse table-auto w-full bg-white">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-700">
                                        <th class="py-4 px-6 text-left font-medium text-sm uppercase">Nama Role</th>
                                        <th class="py-4 px-6 text-left font-medium text-sm uppercase">Permissions</th>
                                        <th class="py-4 px-6 text-left font-medium text-sm uppercase">Dibuat Pada</th>
                                        <th class="py-4 px-6 text-left font-medium text-sm uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <tr v-for="role in filteredRoles" :key="role.id" class="text-gray-700 hover:bg-gray-50">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center">
                                                <div class="mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-sm">{{ role.name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="flex flex-wrap gap-1">
                                                <span 
                                                    v-for="permission in role.permissions" 
                                                    :key="permission"
                                                    class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800"
                                                >
                                                    {{ permission }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="text-sm text-gray-500">{{ role.created_at }}</div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="flex items-center space-x-3">
                                                <Link 
                                                    :href="route('admin.roles.edit', role.id)"
                                                    class="text-[#0B2447] hover:text-[#19376D] inline-flex items-center"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Edit
                                                </Link>
                                                <button 
                                                    @click="deleteRole(role)"
                                                    class="text-red-600 hover:text-red-900 inline-flex items-center"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Empty State -->
                                    <tr v-if="filteredRoles.length === 0">
                                        <td colspan="4" class="py-8 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                                <p class="text-lg font-medium">Tidak ada data role</p>
                                                <p class="text-sm">{{ search ? 'Coba kata kunci pencarian lain' : 'Silakan tambah role baru' }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    roles: Array
});

const search = ref('');

// Computed property for filtered roles
const filteredRoles = computed(() => {
    if (!search.value) return props.roles;
    
    const searchTerm = search.value.toLowerCase();
    return props.roles.filter(role => 
        role.name.toLowerCase().includes(searchTerm) ||
        role.permissions.some(permission => permission.toLowerCase().includes(searchTerm))
    );
});

// Debounced search
let searchTimeout;
const performSearch = () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        // Search logic is handled by computed property
    }, 300);
};

const deleteRole = (role) => {
    if (confirm(`Apakah Anda yakin ingin menghapus role ${role.name}?`)) {
        router.delete(route('admin.roles.destroy', role.id));
    }
};
</script> 