<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: "",
    password_confirmation: "",
});

const validateForm = () => {
    let isValid = true;
    form.clearErrors();

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
        form.post(route("password.store"), {
            onFinish: () => form.reset("password", "password_confirmation"),
        });
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
                <h2 class="text-2xl font-bold text-gray-800">
                    Create New Password
                </h2>
                <p class="text-gray-600 mt-1">
                    Please create a new strong password
                </p>
            </div>

            <form @submit.prevent="submit">
                <!-- Email Display -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700">
                        Email
                    </label>
                    <div
                        class="mt-1 p-2 bg-gray-50 border border-gray-200 rounded-md text-gray-600"
                    >
                        {{ email }}
                    </div>
                </div>

                <!-- New Password Input -->
                <div class="mb-6">
                    <label
                        class="block text-sm font-medium text-gray-700"
                        for="password"
                    >
                        New Password
                    </label>
                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        placeholder="Enter new password"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <!-- Confirm Password Input -->
                <div class="mb-6">
                    <label
                        class="block text-sm font-medium text-gray-700"
                        for="password_confirmation"
                    >
                        Confirm New Password
                    </label>
                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password_confirmation"
                        placeholder="Confirm new password"
                        required
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
                        <span v-else>Reset Password</span>
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
