<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Edit User</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-8">
                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- Name -->
                            <div>
                                <InputLabel for="name" value="Full Name" class="text-gray-700 text-sm font-bold" />
                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full bg-input-bg text-input-text border-input-border focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                    v-model="form.name"
                                    placeholder="Enter user's full name"
                                    required
                                    autofocus
                                />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <!-- Email -->
                            <div>
                                <InputLabel for="email" value="Email Address" class="text-gray-700 text-sm font-bold" />
                                <TextInput
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full bg-input-bg text-input-text border-input-border focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                    v-model="form.email"
                                    placeholder="Enter user's email address"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <!-- WhatsApp -->
                            <div>
                                <InputLabel for="phone" value="WhatsApp Number" class="text-gray-700 text-sm font-bold" />
                                <TextInput
                                    id="phone"
                                    type="text"
                                    class="mt-1 block w-full bg-input-bg text-input-text border-input-border focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                    v-model="form.phone"
                                    placeholder="Enter WhatsApp number (e.g. 081234567890)"
                                    required
                                />
                                <p class="mt-1 text-sm text-gray-500">Format: 08xx-xxxx-xxxx (Indonesian format)</p>
                                <InputError class="mt-2" :message="form.errors.phone" />
                            </div>

                            <!-- Change Password Toggle -->
                            <div class="border-t pt-4">
                                <div class="flex items-center mb-4">
                                    <input
                                        type="checkbox"
                                        id="change_password"
                                        v-model="showPasswordFields"
                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                    />
                                    <label for="change_password" class="ml-2 text-sm font-medium text-gray-700">
                                        Change Password
                                    </label>
                                </div>

                                <!-- Password Fields (Conditional) -->
                                <div v-if="showPasswordFields" class="space-y-4">
                                    <div>
                                        <InputLabel for="password" value="New Password" class="text-gray-700 text-sm font-bold" />
                                        <TextInput
                                            id="password"
                                            type="password"
                                            class="mt-1 block w-full bg-input-bg text-input-text border-input-border focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                            v-model="form.password"
                                            placeholder="Enter new password"
                                        />
                                        <InputError class="mt-2" :message="form.errors.password" />
                                    </div>

                                    <div>
                                        <InputLabel for="password_confirmation" value="Confirm New Password" class="text-gray-700 text-sm font-bold" />
                                        <TextInput
                                            id="password_confirmation"
                                            type="password"
                                            class="mt-1 block w-full bg-input-bg text-input-text border-input-border focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                            v-model="form.password_confirmation"
                                            placeholder="Confirm new password"
                                        />
                                    </div>
                                </div>
                            </div>

                            <!-- Roles -->
                            <div>
                                <InputLabel value="User Roles" class="text-gray-700 text-sm font-bold mb-3" />
                                <div class="mt-2 space-y-3 bg-gray-50 p-4 rounded-lg">
                                    <div v-for="role in roles" :key="role.id" class="flex items-center">
                                        <input
                                            type="checkbox"
                                            :id="'role_' + role.id"
                                            v-model="form.roles"
                                            :value="role.id"
                                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
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
                                    class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    Cancel
                                </Link>
                                <PrimaryButton 
                                    :class="{ 'opacity-25': form.processing }" 
                                    :disabled="form.processing"
                                    class="bg-blue-600 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900"
                                >
                                    Update User
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
import { ref } from 'vue';

const props = defineProps({
    user: Object,
    roles: Array
});

const showPasswordFields = ref(false);

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    phone: props.user.phone,
    password: '',
    password_confirmation: '',
    roles: props.user.roles
});

const submit = () => {
    // Jika password tidak diubah, hapus field password dari form
    if (!showPasswordFields.value) {
        form.password = undefined;
        form.password_confirmation = undefined;
    }
    
    form.put(route('admin.users.update', props.user.id));
};
</script> 