<template>
    <AuthenticatedLayout>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <!-- Search and Filter Section -->
                        <div class="mb-6 flex justify-between items-center">
                            <div class="flex-1 max-w-sm">
                                <input 
                                    type="text" 
                                    placeholder="Search roles..." 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                >
                            </div>
                            <Link 
                                :href="route('admin.roles.create')" 
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add New Role
                            </Link>
                        </div>

                        <!-- Roles Table -->
                        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
                            <table class="border-collapse table-auto w-full bg-white">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-700">
                                        <th class="py-4 px-6 text-left font-medium text-sm uppercase">Role Name</th>
                                        <th class="py-4 px-6 text-left font-medium text-sm uppercase">Permissions</th>
                                        <th class="py-4 px-6 text-left font-medium text-sm uppercase">Created At</th>
                                        <th class="py-4 px-6 text-left font-medium text-sm uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <tr v-for="role in roles" :key="role.id" class="text-gray-700 hover:bg-gray-50">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center">
                                                <div class="mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                    </svg>
                                                </div>
                                                <div class="font-medium text-sm">{{ role.name }}</div>
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
                                                    class="text-blue-600 hover:text-blue-900 inline-flex items-center"
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
                                                    Delete
                                                </button>
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

defineProps({
    roles: Array
});

const deleteRole = (role) => {
    if (confirm(`Are you sure you want to delete ${role.name}?`)) {
        router.delete(route('admin.roles.destroy', role.id));
    }
};
</script> 