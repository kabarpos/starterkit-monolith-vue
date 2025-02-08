<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;
const avatarPreview = ref(null);

const form = useForm({
    name: user.name,
    email: user.email,
    phone: user.phone || '',
    avatar: null,
    _method: 'PATCH'
});

const selectNewAvatar = (e) => {
    const file = e.target.files[0];
    if (file) {
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        if (!allowedTypes.includes(file.type)) {
            alert('File harus berupa gambar (JPG, PNG, atau GIF)');
            e.target.value = '';
            return;
        }

        // Validate file size (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file tidak boleh lebih dari 2MB');
            e.target.value = '';
            return;
        }

        form.avatar = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            avatarPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    if (form.avatar) {
        form.post(route('profile.update'), {
            preserveScroll: true,
            forceFormData: true,
            onSuccess: () => {
                form.reset('password', 'password_confirmation');
                form.avatar = null;
            },
            onError: (errors) => {
                if (errors.avatar) {
                    alert(errors.avatar);
                }
            }
        });
    } else {
        form.post(route('profile.update'), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset('password', 'password_confirmation');
            }
        });
    }
};
</script>

<template>
    <section>
        <form @submit.prevent="submit" class="space-y-6" enctype="multipart/form-data">
            <!-- Avatar -->
            <div class="flex items-start space-x-6">
                <div class="shrink-0">
                    <img 
                        v-if="avatarPreview || user.avatar_url" 
                        :src="avatarPreview || user.avatar_url" 
                        class="h-24 w-24 rounded-full object-cover ring-2 ring-white"
                        alt="Avatar Preview"
                    />
                    <div 
                        v-else 
                        class="h-24 w-24 rounded-full bg-gray-100 flex items-center justify-center"
                    >
                        <svg class="h-12 w-12 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <label 
                        for="avatar"
                        class="group relative cursor-pointer rounded-md bg-white font-medium text-[#0B2447] hover:text-[#19376D] focus-within:outline-none focus-within:ring-2 focus-within:ring-[#19376D] focus-within:ring-offset-2"
                    >
                        <span>Ubah Foto</span>
                        <input 
                            type="file" 
                            id="avatar" 
                            name="avatar"
                            @change="selectNewAvatar" 
                            class="sr-only"
                            accept="image/*"
                        />
                    </label>
                    <p class="mt-2 text-xs text-gray-500">
                        PNG, JPG, GIF up to 2MB
                    </p>
                    <InputError class="mt-2" :message="form.errors.avatar" />
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-2">
                <!-- Name -->
                <div>
                    <InputLabel for="name" value="Nama Lengkap" />
                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Masukkan nama lengkap"
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <!-- Email -->
                <div>
                    <InputLabel for="email" value="Email" />
                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autocomplete="username"
                        placeholder="Masukkan alamat email"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <!-- Phone -->
                <div class="sm:col-span-2">
                    <InputLabel for="phone" value="Nomor WhatsApp" />
                    <TextInput
                        id="phone"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.phone"
                        required
                        placeholder="Contoh: 081234567890"
                    />
                    <p class="mt-1 text-sm text-gray-500">Format: 08xx-xxxx-xxxx (format Indonesia)</p>
                    <InputError class="mt-2" :message="form.errors.phone" />
                </div>
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null" class="mt-6">
                <p class="text-sm text-gray-800">
                    Email Anda belum diverifikasi.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="rounded-md text-sm text-[#0B2447] hover:text-[#19376D] focus:outline-none focus:ring-2 focus:ring-[#19376D] focus:ring-offset-2"
                    >
                        Klik di sini untuk mengirim ulang email verifikasi.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 text-sm font-medium text-green-600"
                >
                    Link verifikasi baru telah dikirim ke alamat email Anda.
                </div>
            </div>

            <div class="flex items-center gap-4 pt-4 border-t">
                <PrimaryButton 
                    :disabled="form.processing"
                    class="bg-[#0B2447] hover:bg-[#19376D]"
                >
                    Simpan Perubahan
                </PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600"
                    >
                        Tersimpan.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
