<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    if (validateForm()) {
        form.post(route("login"), {
            onFinish: () => form.reset("password"),
        });
    }
};

const validateForm = () => {
    let isValid = true;
    form.clearErrors();

    // Email validation
    if (!form.email) {
        form.setError("email", "Email is required");
        isValid = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) {
        form.setError("email", "Invalid email format");
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

    return isValid;
};
</script>

<template>
    <Head title="Login" />

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
                <h2 class="text-2xl font-bold text-gray-800">Welcome Back!</h2>
                <p class="text-gray-600 mt-1">Please sign in to your account</p>
            </div>

            <form @submit.prevent="submit">
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
                        placeholder="Enter your password"
                        autocomplete="current-password"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <!-- Remember Me -->
                <div class="mb-6 flex items-center justify-between">
                    <label class="flex items-center">
                        <input
                            type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            v-model="form.remember"
                        />
                        <span class="ms-2 text-sm text-gray-600"
                            >Remember me</span
                        >
                    </label>

                    <Link
                        :href="route('password.request')"
                        class="text-sm text-indigo-600 hover:text-indigo-500"
                    >
                        Forgot password?
                    </Link>
                </div>

                <!-- Submit Button -->
                <div class="flex flex-col space-y-4">
                    <button
                        type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        :disabled="form.processing"
                    >
                        <span v-if="form.processing">Processing...</span>
                        <span v-else>Sign in</span>
                    </button>

                    <p class="text-center text-sm text-gray-600">
                        Don't have an account?
                        <Link
                            :href="route('register')"
                            class="font-medium text-indigo-600 hover:text-indigo-500"
                        >
                            Sign up
                        </Link>
                    </p>
                </div>
            </form>
        </div>
    </div>
</template>
