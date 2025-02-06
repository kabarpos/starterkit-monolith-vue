<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";

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

const submit = () => {
    if (validateForm()) {
        form.post(route("register"), {
            onFinish: () => form.reset("password", "password_confirmation"),
        });
    }
};
</script>

<template>
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
                <!-- Name Input -->
                <div class="mb-6">
                    <label
                        class="block text-sm font-medium text-gray-700"
                        for="name"
                    >
                        Full Name
                    </label>
                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        placeholder="Enter your full name"
                        autocomplete="name"
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <!-- Email Input -->
                <div class="mb-6">
                    <label
                        class="block text-sm font-medium text-gray-700"
                        for="email"
                    >
                        Email
                    </label>
                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        placeholder="Enter your email"
                        autocomplete="username"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <!-- Phone Input -->
                <div class="mb-6">
                    <label
                        class="block text-sm font-medium text-gray-700"
                        for="phone"
                    >
                        Phone (WhatsApp)
                    </label>
                    <TextInput
                        id="phone"
                        type="tel"
                        class="mt-1 block w-full"
                        v-model="form.phone"
                        placeholder="Enter your WhatsApp number"
                    />
                    <InputError class="mt-2" :message="form.errors.phone" />
                </div>

                <!-- Password Input -->
                <div class="mb-6">
                    <label
                        class="block text-sm font-medium text-gray-700"
                        for="password"
                    >
                        Password
                    </label>
                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        placeholder="Create a password"
                        autocomplete="new-password"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <!-- Password Confirmation -->
                <div class="mb-6">
                    <label
                        class="block text-sm font-medium text-gray-700"
                        for="password_confirmation"
                    >
                        Confirm Password
                    </label>
                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password_confirmation"
                        placeholder="Confirm your password"
                        autocomplete="new-password"
                    />
                    <InputError
                        class="mt-2"
                        :message="form.errors.password_confirmation"
                    />
                </div>

                <!-- Submit Button -->
                <div class="flex flex-col space-y-4">
                    <button
                        type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        :disabled="form.processing"
                    >
                        <span v-if="form.processing">Processing...</span>
                        <span v-else>Create Account</span>
                    </button>

                    <p class="text-center text-sm text-gray-600">
                        Already have an account?
                        <Link
                            :href="route('login')"
                            class="font-medium text-indigo-600 hover:text-indigo-500"
                        >
                            Sign in
                        </Link>
                    </p>
                </div>
            </form>
        </div>
    </div>
</template>
