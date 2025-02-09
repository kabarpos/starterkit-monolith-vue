<template>
    <Head title="Edit Role" />

    <AuthenticatedLayout :auth="auth">
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-[var(--text-primary)]">
                    Edit Role
                </h2>
            </div>
        </template>

        <Card class="max-w-2xl mx-auto">
            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <InputLabel for="name" value="Nama Role" />
                    <TextInput
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="mt-1 block w-full"
                        required
                        autofocus
                    />
                    <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="permissions" value="Permissions" />
                    <div class="mt-4 space-y-4">
                        <div v-for="(permissionGroup, module) in groupedPermissions" :key="module" class="space-y-2">
                            <h3 class="font-medium text-[var(--text-primary)]">{{ module }}</h3>
                            <div class="ml-4 grid grid-cols-2 gap-4">
                                <label v-for="permission in permissionGroup" :key="permission" class="inline-flex items-center">
                                    <input
                                        type="checkbox"
                                        :value="permission"
                                        v-model="form.permissions"
                                        class="rounded border-[var(--border-primary)] text-[var(--primary-600)] focus:ring-[var(--primary-500)]"
                                    />
                                    <span class="ml-2 text-[var(--text-primary)]">{{ permission }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <InputError :message="form.errors.permissions" class="mt-2" />
                </div>

                <div class="flex items-center justify-end gap-4">
                    <Link
                        :href="route('admin.roles.index')"
                        class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 text-sm font-medium rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200"
                    >
                        Batal
                    </Link>
                    <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200"
                        :disabled="form.processing"
                    >
                        <span v-if="form.processing">Memproses...</span>
                        <span v-else>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </Card>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from '@/Components/Card.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import { computed } from 'vue';

const props = defineProps({
    auth: {
        type: Object,
        required: true
    },
    role: {
        type: Object,
        required: true
    },
    permissions: {
        type: Array,
        required: true
    }
});

const groupedPermissions = computed(() => {
    return props.permissions.reduce((groups, permission) => {
        if (typeof permission === 'string' && permission.includes('.')) {
            const [module] = permission.split('.');
            if (!groups[module]) {
                groups[module] = [];
            }
            groups[module].push(permission);
        } else if (typeof permission === 'object' && permission.name) {
            const [module] = permission.name.split('.');
            if (!groups[module]) {
                groups[module] = [];
            }
            groups[module].push(permission.name);
        }
        return groups;
    }, {});
});

const form = useForm({
    name: props.role.name,
    permissions: Array.isArray(props.role.permissions) 
        ? props.role.permissions.map(p => typeof p === 'string' ? p : p.name)
        : []
});

const submit = () => {
    form.put(route('admin.roles.update', props.role.id), {
        preserveScroll: true
    });
};
</script> 