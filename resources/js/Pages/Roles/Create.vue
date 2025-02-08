<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Tambah Role Baru</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-8">
                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- Role Name -->
                            <div>
                                <InputLabel for="name" value="Nama Role" class="text-gray-700 text-sm font-bold" />
                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full bg-input-bg text-input-text border-input-border focus:border-[#19376D] focus:ring-[#19376D] rounded-md shadow-sm"
                                    v-model="form.name"
                                    placeholder="Masukkan nama role"
                                    required
                                    autofocus
                                />
                                <p class="mt-1 text-sm text-gray-500">Nama ini akan digunakan untuk mengidentifikasi role dalam sistem.</p>
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <!-- Permissions -->
                            <div>
                                <InputLabel value="Permissions Role" class="text-gray-700 text-sm font-bold mb-3" />
                                <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                                    <div v-for="permission in permissions" :key="permission.id" class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input
                                                type="checkbox"
                                                :id="'permission_' + permission.id"
                                                v-model="form.permissions"
                                                :value="permission.id"
                                                class="w-4 h-4 text-[#0B2447] border-gray-300 rounded focus:ring-[#19376D]"
                                            />
                                        </div>
                                        <div class="ml-3">
                                            <label :for="'permission_' + permission.id" class="text-sm font-medium text-gray-700">
                                                {{ permission.name }}
                                            </label>
                                            <p class="text-xs text-gray-500">
                                                {{ getPermissionDescription(permission.name) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <InputError class="mt-2" :message="form.errors.permissions" />
                            </div>

                            <!-- Form Actions -->
                            <div class="flex items-center justify-end gap-4 pt-4 border-t">
                                <Link
                                    :href="route('admin.roles.index')"
                                    class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-[#19376D] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    Batal
                                </Link>
                                <PrimaryButton 
                                    :class="{ 'opacity-25': form.processing }" 
                                    :disabled="form.processing"
                                    class="bg-[#0B2447] hover:bg-[#19376D] focus:bg-[#19376D]"
                                >
                                    Simpan Role
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    permissions: Array
});

const form = useForm({
    name: '',
    permissions: []
});

const getPermissionDescription = (permission) => {
    const descriptions = {
        'view users': 'Dapat melihat daftar semua pengguna dalam sistem',
        'create users': 'Dapat membuat pengguna baru dalam sistem',
        'edit users': 'Dapat mengubah informasi pengguna yang ada',
        'delete users': 'Dapat menghapus pengguna dari sistem',
        'view roles': 'Dapat melihat daftar semua role',
        'create roles': 'Dapat membuat role baru',
        'edit roles': 'Dapat mengubah role yang ada',
        'delete roles': 'Dapat menghapus role dari sistem'
    };
    return descriptions[permission] || permission;
};

const submit = () => {
    form.post(route('admin.roles.store'));
};
</script> 