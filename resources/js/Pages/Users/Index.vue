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
                                    placeholder="Search users..." 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                >
                            </div>
                            <Link 
                                :href="route('admin.users.create')" 
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add New User
                            </Link>
                        </div>

                        <!-- Users Table -->
                        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
                            <table class="border-collapse table-auto w-full bg-white">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-700">
                                        <th class="py-4 px-6 text-left font-medium text-sm uppercase">Name</th>
                                        <th class="py-4 px-6 text-left font-medium text-sm uppercase">Email</th>
                                        <th class="py-4 px-6 text-left font-medium text-sm uppercase">WhatsApp</th>
                                        <th class="py-4 px-6 text-left font-medium text-sm uppercase">Roles</th>
                                        <th class="py-4 px-6 text-left font-medium text-sm uppercase">Status</th>
                                        <th class="py-4 px-6 text-left font-medium text-sm uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <tr v-for="user in users" :key="user.id" class="text-gray-700 hover:bg-gray-50">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    <img 
                                                        class="h-10 w-10 rounded-full" 
                                                        :src="`https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=random`" 
                                                        :alt="user.name"
                                                    >
                                                </div>
                                                <div class="ml-4">
                                                    <div class="font-medium text-sm">{{ user.name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="text-sm">{{ user.email }}</div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="text-sm">{{ user.phone || '-' }}</div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="flex flex-wrap gap-1">
                                                <span 
                                                    v-for="role in user.roles" 
                                                    :key="role"
                                                    class="px-2 py-1 text-xs font-medium rounded-full"
                                                    :class="{
                                                        'bg-blue-100 text-blue-800': role === 'admin',
                                                        'bg-green-100 text-green-800': role === 'user'
                                                    }"
                                                >
                                                    {{ role }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="flex items-center space-x-3">
                                                <Link 
                                                    :href="route('admin.users.edit', user.id)"
                                                    class="text-blue-600 hover:text-blue-900 inline-flex items-center"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Edit
                                                </Link>
                                                <button 
                                                    @click="deleteUser(user)"
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
    users: Array
});

const deleteUser = (user) => {
    if (confirm(`Are you sure you want to delete ${user.name}?`)) {
        router.delete(route('admin.users.destroy', user.id));
    }
};
</script> 