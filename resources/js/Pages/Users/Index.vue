<template>
    <AuthenticatedLayout :auth="auth">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Manajemen User</h2>
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
                                        placeholder="Cari user..." 
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
                                :href="route('admin.users.create')" 
                                class="inline-flex items-center px-4 py-2 bg-[#0B2447] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#19376D] focus:bg-[#19376D] active:bg-[#19376D] focus:outline-none focus:ring-2 focus:ring-[#19376D] focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Tambah User Baru
                            </Link>
                        </div>

                        <!-- Users Table -->
                        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
                            <table class="border-collapse table-auto w-full bg-white">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-700">
                                        <th class="py-4 px-6 text-left font-medium text-sm uppercase">Nama</th>
                                        <th class="py-4 px-6 text-left font-medium text-sm uppercase">Email</th>
                                        <th class="py-4 px-6 text-left font-medium text-sm uppercase">WhatsApp</th>
                                        <th class="py-4 px-6 text-left font-medium text-sm uppercase">Roles</th>
                                        <th class="py-4 px-6 text-left font-medium text-sm uppercase">Status</th>
                                        <th class="py-4 px-6 text-left font-medium text-sm uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <tr v-for="user in filteredUsers" :key="user.id" class="text-gray-700 hover:bg-gray-50">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    <img 
                                                        class="h-10 w-10 rounded-full object-cover"
                                                        :src="user.avatar_url 
                                                            ? user.avatar_url
                                                            : `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=random&color=fff`"
                                                        :alt="user.name"
                                                    >
                                                </div>
                                                <div class="ml-4">
                                                    <div class="font-medium text-sm">{{ user.name }}</div>
                                                    <div class="text-xs text-gray-500">Bergabung {{ user.created_at }}</div>
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
                                            <div class="flex flex-col">
                                                <span 
                                                    class="px-2 py-1 text-xs font-medium rounded-full w-fit"
                                                    :class="{
                                                        'bg-yellow-100 text-yellow-800': user.status === 'pending',
                                                        'bg-green-100 text-green-800': user.status === 'active',
                                                        'bg-red-100 text-red-800': user.status === 'rejected',
                                                        'bg-red-100 text-red-800': user.status === 'banned',
                                                        'bg-gray-100 text-gray-800': user.status === 'inactive'
                                                    }"
                                                >
                                                    {{ (user.status || 'pending').charAt(0).toUpperCase() + (user.status || 'pending').slice(1) }}
                                                </span>
                                                <p v-if="user.status_reason" class="mt-1 text-xs text-gray-500 max-w-xs truncate" :title="user.status_reason">
                                                    {{ user.status_reason }}
                                                </p>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="flex items-center space-x-3">
                                                <!-- Status Actions -->
                                                <div class="relative" v-if="user.status === 'pending'">
                                                    <div class="flex space-x-2">
                                                        <button
                                                            @click="openStatusModal(user, 'approve')"
                                                            class="text-green-600 hover:text-green-900 inline-flex items-center"
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            Setujui
                                                        </button>
                                                        <button
                                                            @click="openStatusModal(user, 'reject')"
                                                            class="text-red-600 hover:text-red-900 inline-flex items-center"
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            Tolak
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="relative" v-if="user.status === 'active'">
                                                    <div class="flex space-x-2">
                                                        <button
                                                            @click="openStatusModal(user, 'deactivate')"
                                                            class="text-yellow-600 hover:text-yellow-900 inline-flex items-center text-sm"
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                            </svg>
                                                            Nonaktifkan
                                                        </button>
                                                        <button
                                                            @click="openStatusModal(user, 'ban')"
                                                            class="text-red-600 hover:text-red-900 inline-flex items-center text-sm"
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                            </svg>
                                                            Banned
                                                        </button>
                                                    </div>
                                                </div>
                                                <Link 
                                                    :href="route('admin.users.edit', user.id)"
                                                    class="text-blue-600 hover:text-blue-900 inline-flex items-center text-sm"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Edit
                                                </Link>
                                                <button 
                                                    @click="deleteUser(user)"
                                                    class="text-red-600 hover:text-red-900 inline-flex items-center text-sm"
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
                                    <tr v-if="filteredUsers.length === 0">
                                        <td colspan="6" class="py-8 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                                <p class="text-lg font-medium">Tidak ada data user</p>
                                                <p class="text-sm">{{ search ? 'Coba kata kunci pencarian lain' : 'Silakan tambah user baru' }}</p>
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

        <!-- Status Modal -->
        <Modal :show="showStatusModal" @close="showStatusModal = false">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ 
                        statusAction === 'approve' ? 'Setujui Akun User' :
                        statusAction === 'reject' ? 'Tolak Akun User' :
                        statusAction === 'deactivate' ? 'Nonaktifkan Akun User' :
                        statusAction === 'ban' ? 'Banned Akun User' : ''
                    }}
                </h2>
                <div class="mt-6">
                    <InputLabel for="reason" :value="statusAction === 'approve' ? 'Alasan (Opsional)' : 'Alasan (Wajib)'" />
                    <textarea
                        id="reason"
                        v-model="statusReason"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        rows="3"
                        :placeholder="`Masukkan alasan ${statusAction === 'approve' ? '(opsional)' : ''}`"
                        :required="statusAction !== 'approve'"
                    ></textarea>
                    <p v-if="statusAction !== 'approve'" class="mt-1 text-sm text-gray-500">
                        Minimal 10 karakter
                    </p>
                </div>
                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="showStatusModal = false" class="mr-3">
                        Batal
                    </SecondaryButton>
                    <component 
                        :is="statusAction === 'approve' ? 'PrimaryButton' : 'DangerButton'"
                        @click="handleStatusAction"
                        :disabled="statusAction !== 'approve' && statusReason.length < 10"
                    >
                        {{ 
                            statusAction === 'approve' ? 'Setujui' :
                            statusAction === 'reject' ? 'Tolak' :
                            statusAction === 'deactivate' ? 'Nonaktifkan' :
                            statusAction === 'ban' ? 'Banned' : ''
                        }}
                    </component>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

const props = defineProps({
    auth: {
        type: Object,
        required: true
    },
    users: {
        type: Array,
        required: true
    }
});

const search = ref('');
const selectedUser = ref(null);
const showStatusModal = ref(false);
const statusAction = ref('');
const statusReason = ref('');

// Computed property for filtered users
const filteredUsers = computed(() => {
    if (!search.value) return props.users;
    
    const searchTerm = search.value.toLowerCase();
    return props.users.filter(user => 
        user.name.toLowerCase().includes(searchTerm) ||
        user.email.toLowerCase().includes(searchTerm) ||
        user.phone?.toLowerCase().includes(searchTerm) ||
        user.roles.some(role => role.toLowerCase().includes(searchTerm)) ||
        user.status.toLowerCase().includes(searchTerm)
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

const openStatusModal = (user, action) => {
    selectedUser.value = user;
    statusAction.value = action;
    statusReason.value = '';
    showStatusModal.value = true;
};

const handleStatusAction = () => {
    if (statusAction.value !== 'approve' && statusReason.value.length < 10) {
        return;
    }

    const actions = {
        'approve': () => approveUser(),
        'reject': () => rejectUser(),
        'deactivate': () => deactivateUser(),
        'ban': () => banUser()
    };

    if (actions[statusAction.value]) {
        actions[statusAction.value]();
    }
};

const approveUser = () => {
    router.put(route('admin.users.approve', selectedUser.value.id), {
        reason: statusReason.value
    }, {
        onSuccess: () => {
            showStatusModal.value = false;
            selectedUser.value = null;
            statusReason.value = '';
        }
    });
};

const rejectUser = () => {
    router.put(route('admin.users.reject', selectedUser.value.id), {
        reason: statusReason.value
    }, {
        onSuccess: () => {
            showStatusModal.value = false;
            selectedUser.value = null;
            statusReason.value = '';
        }
    });
};

const deactivateUser = () => {
    router.put(route('admin.users.deactivate', selectedUser.value.id), {
        reason: statusReason.value
    }, {
        onSuccess: () => {
            showStatusModal.value = false;
            selectedUser.value = null;
            statusReason.value = '';
        }
    });
};

const banUser = () => {
    router.put(route('admin.users.ban', selectedUser.value.id), {
        reason: statusReason.value
    }, {
        onSuccess: () => {
            showStatusModal.value = false;
            selectedUser.value = null;
            statusReason.value = '';
        }
    });
};

const deleteUser = (user) => {
    if (confirm(`Apakah Anda yakin ingin menghapus user ${user.name}?`)) {
        router.delete(route('admin.users.destroy', user.id));
    }
};
</script> 