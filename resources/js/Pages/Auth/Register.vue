<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const form = useForm({
    name: "",
    email: "",
    phone: "",
    password: "",
    password_confirmation: "",
});

const validateForm = () => {
    let isValid = true;
    form.clearErrors();

    // Name validation
    if (!form.name) {
        form.setError("name", "Name is required");
        isValid = false;
    } else if (form.name.length < 2) {
        form.setError("name", "Name must be at least 2 characters");
        isValid = false;
    }

    // Email validation
    if (!form.email) {
        form.setError("email", "Email is required");
        isValid = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) {
        form.setError("email", "Invalid email format");
        isValid = false;
    }

    // Phone validation
    if (form.phone && !/^\+?\d{10,13}$/.test(form.phone)) {
        form.setError("phone", "Invalid phone number format");
        isValid = false;
    }

    // Password validation
    if (!form.password) {
        form.setError("password", "Password is required");
        isValid = false;
    } else if (form.password.length < 8) {
        form.setError("password", "Password must be at least 8 characters");
        isValid = false;
    }

    // Password confirmation
    if (form.password !== form.password_confirmation) {
        form.setError(
            "password_confirmation",
            "Password confirmation does not match"
        );
        isValid = false;
    }

    return isValid;
};

const validatePhone = () => {
    // Hapus karakter non-digit
    form.phone = form.phone.replace(/\D/g, '');
    
    // Pastikan dimulai dengan '08'
    if (form.phone && !form.phone.startsWith('08')) {
        form.phone = '08';
    }
    
    // Batasi panjang maksimal 13 digit
    if (form.phone.length > 13) {
        form.phone = form.phone.slice(0, 13);
    }
};

const submit = () => {
    if (validateForm()) {
        form.post("/register", {
            onFinish: () => form.reset("password", "password_confirmation"),
        });
    }
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <div
            class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100"
        >
            <div
                class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
            >
                <!-- Logo Section -->
                <div class="flex justify-center mb-8">
                    <ApplicationLogo class="w-20 h-20" />
                </div>

                <!-- Welcome Text -->
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800">
                        Create an Account
                    </h2>
                    <p class="text-gray-600 mt-1">
                        Fill in your details to get started
                    </p>
                </div>

                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="name" value="Name" />
                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full bg-input-bg text-input-text border-input-border focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                            v-model="form.name"
                            placeholder="Enter your full name"
                            required
                            autofocus
                            autocomplete="name"
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="email" value="Email" />
                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full bg-input-bg text-input-text border-input-border focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                            v-model="form.email"
                            placeholder="Enter your email address"
                            required
                            autocomplete="username"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="phone" value="WhatsApp Number" />
                        <TextInput
                            id="phone"
                            type="text"
                            class="mt-1 block w-full bg-input-bg text-input-text border-input-border focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                            v-model="form.phone"
                            placeholder="Enter your WhatsApp number (e.g. 081234567890)"
                            required
                            maxlength="13"
                            @input="validatePhone"
                        />
                        <p class="mt-1 text-sm text-gray-500">Format: 08xx-xxxx-xxxx (10-13 digits)</p>
                        <InputError class="mt-2" :message="form.errors.phone" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="password" value="Password" />
                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full bg-input-bg text-input-text border-input-border focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                            v-model="form.password"
                            placeholder="Enter your password"
                            required
                            autocomplete="new-password"
                        />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="password_confirmation" value="Confirm Password" />
                        <TextInput
                            id="password_confirmation"
                            type="password"
                            class="mt-1 block w-full bg-input-bg text-input-text border-input-border focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                            v-model="form.password_confirmation"
                            placeholder="Confirm your password"
                            required
                            autocomplete="new-password"
                        />
                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <Link
                            :href="route('login')"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Already registered?
                        </Link>

                        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Register
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>
