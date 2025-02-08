<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Tambah User Baru</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-8">
                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- Name -->
                            <div>
                                <InputLabel for="name" value="Nama Lengkap" class="text-gray-700 text-sm font-bold" />
                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full bg-input-bg text-input-text border-input-border focus:border-[#19376D] focus:ring-[#19376D] rounded-md shadow-sm"
                                    v-model="form.name"
                                    placeholder="Masukkan nama lengkap"
                                    required
                                    autofocus
                                />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <!-- Email -->
                            <div>
                                <InputLabel for="email" value="Alamat Email" class="text-gray-700 text-sm font-bold" />
                                <TextInput
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full bg-input-bg text-input-text border-input-border focus:border-[#19376D] focus:ring-[#19376D] rounded-md shadow-sm"
                                    v-model="form.email"
                                    placeholder="Masukkan alamat email"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <!-- WhatsApp -->
                            <div>
                                <InputLabel for="phone" value="Nomor WhatsApp" class="text-gray-700 text-sm font-bold" />
                                <TextInput
                                    id="phone"
                                    type="text"
                                    class="mt-1 block w-full bg-input-bg text-input-text border-input-border focus:border-[#19376D] focus:ring-[#19376D] rounded-md shadow-sm"
                                    v-model="form.phone"
                                    placeholder="Contoh: 081234567890"
                                    required
                                />
                                <p class="mt-1 text-sm text-gray-500">Format: 08xx-xxxx-xxxx (format Indonesia)</p>
                                <InputError class="mt-2" :message="form.errors.phone" />
                            </div>

                            <!-- Password -->
                            <div>
                                <InputLabel for="password" value="Password" class="text-gray-700 text-sm font-bold" />
                                <TextInput
                                    id="password"
                                    type="password"
                                    class="mt-1 block w-full bg-input-bg text-input-text border-input-border focus:border-[#19376D] focus:ring-[#19376D] rounded-md shadow-sm"
                                    v-model="form.password"
                                    placeholder="Masukkan password"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <InputLabel for="password_confirmation" value="Konfirmasi Password" class="text-gray-700 text-sm font-bold" />
                                <TextInput
                                    id="password_confirmation"
                                    type="password"
                                    class="mt-1 block w-full bg-input-bg text-input-text border-input-border focus:border-[#19376D] focus:ring-[#19376D] rounded-md shadow-sm"
                                    v-model="form.password_confirmation"
                                    placeholder="Konfirmasi password"
                                    required
                                />
                            </div>

                            <!-- Roles -->
                            <div>
                                <InputLabel value="Role User" class="text-gray-700 text-sm font-bold mb-3" />
                                <div class="mt-2 space-y-3 bg-gray-50 p-4 rounded-lg">
                                    <div v-for="role in roles" :key="role.id" class="flex items-center">
                                        <input
                                            type="checkbox"
                                            :id="'role_' + role.id"
                                            v-model="form.roles"
                                            :value="role.id"
                                            class="w-4 h-4 text-[#0B2447] border-gray-300 rounded focus:ring-[#19376D]"
                                        />
                                        <label :for="'role_' + role.id" class="ml-3 text-sm font-medium text-gray-700">
                                            {{ role.name }}
                                        </label>
                                    </div>
                                </div>
                                <InputError class="mt-2" :message="form.errors.roles" />
                            </div>

                            <!-- Form Actions -->
                            <div class="flex items-center justify-end gap-4 pt-4 border-t">
                                <Link
                                    :href="route('admin.users.index')"
                                    class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-[#19376D] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    Batal
                                </Link>
                                <PrimaryButton 
                                    :class="{ 'opacity-25': form.processing }" 
                                    :disabled="form.processing"
                                    class="bg-[#0B2447] hover:bg-[#19376D] focus:bg-[#19376D]"
                                >
                                    Simpan User
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
    roles: Array
});

const form = useForm({
    name: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
    roles: []
});

const submit = () => {
    form.post(route('admin.users.store'));
};
</script> 