<script setup>
import { ref } from "vue";

const isSidebarOpen = ref(false);
import { Link } from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import {
    ChartBarIcon,
    UserGroupIcon,
    CubeIcon,
    ChatBubbleLeftIcon,
    CreditCardIcon,
    CogIcon,
    ShieldCheckIcon,
    Bars3Icon,
} from "@heroicons/vue/24/outline";

// Navigation Links
const navigation = [
    { name: "Overview", href: "/dashboard", icon: ChartBarIcon, current: true },
    { name: "Statistics", href: "#", icon: ChartBarIcon, current: false },
    { name: "Customers", href: "#", icon: UserGroupIcon, current: false },
    { name: "Product", href: "#", icon: CubeIcon, current: false },
    {
        name: "Messages",
        href: "#",
        icon: ChatBubbleLeftIcon,
        count: 13,
        current: false,
    },
    { name: "Transactions", href: "#", icon: CreditCardIcon, current: false },
];

const general = [
    { name: "Settings", href: "#", icon: CogIcon, current: false },
    { name: "Security", href: "#", icon: ShieldCheckIcon, current: false },
];

const user = {
    name: "Fandaww Punx",
    email: "fandaww6@gmail.com",
    imageUrl: "images/user-avatar.jpg",
};

defineProps({
    auth: Object,
});
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <div
            class="fixed inset-y-0 w-64 flex-col bg-[#0B2447]"
            :class="{ 'hidden md:flex': !isSidebarOpen, flex: isSidebarOpen }"
        >
            <!-- Sidebar header -->
            <div class="flex h-16 shrink-0 items-center px-6">
                <ApplicationLogo class="h-8 w-auto text-white" />
                <span class="ml-2 text-xl font-semibold text-white"
                    >Siohioma</span
                >
            </div>
            <hr class="border-gray-600" />
            <!-- Sidebar content -->
            <div class="flex flex-1 flex-col overflow-y-auto">
                <nav class="flex-1 px-4 py-4 gap-10">
                    <div class="mt-4">
                        <p
                            class="px-2 text-sm font-semibold text-gray-400 mb-4"
                        >
                            DASHBOARD
                        </p>

                        <!-- Navigation Items -->
                        <div class="mt-2">
                            <template
                                v-for="item in navigation"
                                :key="item.name"
                            >
                                <Link
                                    :href="item.href"
                                    :class="[
                                        item.current
                                            ? 'bg-[#19376D] text-white'
                                            : 'text-gray-300 hover:bg-[#19376D] hover:text-white',
                                        'group flex items-center px-2 py-2 text-sm font-medium rounded-md',
                                    ]"
                                >
                                    <component
                                        :is="item.icon"
                                        :class="[
                                            item.current
                                                ? 'text-white'
                                                : 'text-gray-400 group-hover:text-white',
                                            'mr-3 flex-shrink-0 h-6 w-6',
                                        ]"
                                    />
                                    {{ item.name }}
                                    <span
                                        v-if="item.count"
                                        class="ml-auto inline-block py-0.5 px-2 text-xs rounded-full bg-green-500 text-white"
                                    >
                                        {{ item.count }}
                                    </span>
                                </Link>
                            </template>
                        </div>
                    </div>
                    <!-- General Section -->
                    <div class="mt-8">
                        <p
                            class="px-2 text-sm font-semibold text-gray-400 mb-4"
                        >
                            ADMIN AREA
                        </p>
                        <div class="mt-2">
                            <template v-for="item in general" :key="item.name">
                                <Link
                                    :href="item.href"
                                    class="text-gray-300 hover:bg-[#19376D] hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md"
                                >
                                    <component
                                        :is="item.icon"
                                        class="text-gray-400 group-hover:text-white mr-3 flex-shrink-0 h-6 w-6"
                                    />
                                    {{ item.name }}
                                </Link>
                            </template>
                        </div>
                    </div>
                </nav>

                <!-- User Profile -->
                <div class="border-t border-gray-700 p-4">
                    <div class="flex items-center">
                        <img
                            class="h-8 w-8 rounded-full"
                            :src="user.imageUrl"
                            :alt="user.name"
                        />
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">
                                {{ user.name }}
                            </p>
                            <p class="text-xs text-gray-400">
                                {{ user.email }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="md:pl-64">
            <!-- Top header -->
            <div class="sticky top-0 z-10 bg-white shadow md:hidden">
                <div class="flex h-16 items-center justify-between px-6">
                    <div class="flex items-center justify-between w-full">
                        <button
                            @click="isSidebarOpen = !isSidebarOpen"
                            class="rounded-md p-2 text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                        >
                            <span class="sr-only">Open sidebar</span>
                            <Bars3Icon class="h-6 w-6" aria-hidden="true" />
                        </button>
                        <ApplicationLogo class="h-8 w-auto text-white" />
                        <span class="sr-only">Siohioma</span>
                    </div>
                </div>
            </div>

            <!-- Page content -->
            <main class="py-6 px-6">
                <slot />
            </main>
        </div>
    </div>
</template>
