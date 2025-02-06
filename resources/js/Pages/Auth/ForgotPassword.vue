<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
});

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

    return isValid;
};

const submit = () => {
    if (validateForm()) {
        form.post(route("password.email"));
    }
};
</script>

<template>
    <Head title="Reset Password" />

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

            <!-- Title and Description -->
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800">Reset Password</h2>
                <p class="text-gray-600 mt-1">
                    Enter your email to reset your password
                </p>
            </div>

            <!-- Success Message -->
            <div
                v-if="status"
                class="mb-4 p-4 bg-green-50 border border-green-200 rounded-md"
            >
                <p class="text-sm text-green-600">{{ status }}</p>
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
                        placeholder="Enter your registered email"
                        required
                        autofocus
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <!-- Submit Button -->
                <div class="flex flex-col space-y-4">
                    <button
                        type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        :disabled="form.processing"
                    >
                        <span v-if="form.processing">Processing...</span>
                        <span v-else>Send Reset Link</span>
                    </button>

                    <p class="text-center text-sm text-gray-600">
                        Remember your password?
                        <Link
                            :href="route('login')"
                            class="font-medium text-indigo-600 hover:text-indigo-500"
                        >
                            Back to login
                        </Link>
                    </p>
                </div>
            </form>
        </div>
    </div>
</template>
