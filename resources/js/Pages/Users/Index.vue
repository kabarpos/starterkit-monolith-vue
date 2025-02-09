<template>
    <Head title="Users" />

    <AuthenticatedLayout :auth="auth">
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-[var(--text-primary)]">
                    Manajemen Pengguna
                </h2>
                <Link
                    :href="route('admin.users.create')"
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200"
                >
                    Tambah Pengguna
                </Link>
            </div>
        </template>

        <div class="space-y-6">
            <!-- Search and Filter Section -->
            <Card class="p-4">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <TextInput
                            v-model="search"
                            type="search"
                            class="w-full"
                            placeholder="Cari pengguna..."
                        />
                    </div>
                    <div class="flex gap-4">
                        <select
                            v-model="filters.role"
                            class="rounded-lg border-[var(--border-primary)] bg-[var(--bg-secondary)] text-[var(--text-primary)] focus:border-[var(--primary-500)] focus:ring-[var(--primary-500)]"
                        >
                            <option value="">Semua Role</option>
                            <option v-for="role in roles" :key="role" :value="role">
                                {{ role }}
                            </option>
                        </select>
                        <select
                            v-model="filters.status"
                            class="rounded-lg border-[var(--border-primary)] bg-[var(--bg-secondary)] text-[var(--text-primary)] focus:border-[var(--primary-500)] focus:ring-[var(--primary-500)]"
                        >
                            <option value="">Semua Status</option>
                            <option value="active">Aktif</option>
                            <option value="inactive">Nonaktif</option>
                        </select>
                    </div>
                </div>
            </Card>

            <!-- Users Table -->
            <Card>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[var(--border-primary)]">
                        <thead class="bg-[var(--bg-secondary)]">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[var(--text-secondary)] uppercase tracking-wider">
                                    Pengguna
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[var(--text-secondary)] uppercase tracking-wider">
                                    Role
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[var(--text-secondary)] uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[var(--text-secondary)] uppercase tracking-wider">
                                    Bergabung
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-[var(--bg-secondary)] divide-y divide-[var(--border-primary)]">
                            <tr v-for="user in filteredUsers" :key="user.id" class="hover:bg-[var(--bg-secondary)]/50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <img
                                                :src="user.avatar_url || `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=random&color=fff`"
                                                :alt="user.name"
                                                class="h-10 w-10 rounded-full object-cover"
                                            />
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-[var(--text-primary)]">
                                                {{ user.name }}
                                            </div>
                                            <div class="text-sm text-[var(--text-secondary)]">
                                                {{ user.email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-wrap gap-2">
                                        <Badge 
                                            v-for="role in user.roles" 
                                            :key="role"
                                            variant="primary"
                                        >
                                            {{ role }}
                                        </Badge>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <Badge 
                                        :variant="user.status === 'active' ? 'success' : 'warning'"
                                    >
                                        {{ user.status === 'active' ? 'Aktif' : 'Nonaktif' }}
                                    </Badge>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-secondary)]">
                                    {{ formatDate(user.created_at) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-3">
                                        <Link
                                            :href="route('admin.users.edit', user.id)"
                                            class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200"
                                        >
                                            Edit
                                        </Link>
                                        <button
                                            @click="confirmUserDeletion(user)"
                                            class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white text-sm font-medium rounded-lg transition-colors duration-200"
                                        >
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </Card>
        </div>

        <!-- Delete User Modal -->
        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-[var(--text-primary)]">
                    Hapus Pengguna
                </h2>

                <p class="mt-3 text-sm text-[var(--text-secondary)]">
                    Apakah Anda yakin ingin menghapus pengguna ini? Semua data yang terkait dengan pengguna ini akan dihapus secara permanen.
                </p>

                <div class="mt-6 flex justify-end gap-4">
                    <SecondaryButton @click="closeModal" class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                        Batal
                    </SecondaryButton>

                    <DangerButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                        class="bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white"
                    >
                        Hapus Pengguna
                    </DangerButton>
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
import { Head } from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
import TextInput from '@/Components/TextInput.vue';
import Badge from '@/Components/Badge.vue';

const props = defineProps({
    auth: {
        type: Object,
        required: true
    },
    users: {
        type: Array,
        required: true
    },
    roles: {
        type: Array,
        default: () => []
    }
});

const search = ref('');
const selectedUser = ref(null);
const confirmingUserDeletion = ref(false);

// Tambahkan state filters
const filters = ref({
    role: '',
    status: ''
});

// Update computed property untuk filtered users dengan filter
const filteredUsers = computed(() => {
    let result = props.users;
    
    // Filter berdasarkan pencarian
    if (search.value) {
        const searchTerm = search.value.toLowerCase();
        result = result.filter(user => 
            user.name.toLowerCase().includes(searchTerm) ||
            user.email.toLowerCase().includes(searchTerm) ||
            user.phone?.toLowerCase().includes(searchTerm) ||
            user.roles.some(role => role.toLowerCase().includes(searchTerm)) ||
            user.status.toLowerCase().includes(searchTerm)
        );
    }
    
    // Filter berdasarkan role
    if (filters.value.role) {
        result = result.filter(user => 
            user.roles.includes(filters.value.role)
        );
    }
    
    // Filter berdasarkan status
    if (filters.value.status) {
        result = result.filter(user => 
            user.status === filters.value.status
        );
    }
    
    return result;
});

const closeModal = () => {
    confirmingUserDeletion.value = false;
    selectedUser.value = null;
};

const confirmUserDeletion = (user) => {
    selectedUser.value = user;
    confirmingUserDeletion.value = true;
};

const deleteUser = () => {
    if (selectedUser.value) {
        router.delete(route('admin.users.destroy', selectedUser.value.id), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
        });
    }
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};
</script> 