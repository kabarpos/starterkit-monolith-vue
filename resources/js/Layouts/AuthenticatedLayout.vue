<script setup>
import { ref, computed, onMounted } from "vue";
import { Link, router } from "@inertiajs/vue3";
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

const isSidebarOpen = ref(false);
const isProfileMenuOpen = ref(false);

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

const admin = [
    { 
        name: "User Management", 
        href: route('admin.users.index'), 
        icon: UserGroupIcon, 
        current: false 
    },
    { 
        name: "Role Management", 
        href: route('admin.roles.index'), 
        icon: ShieldCheckIcon, 
        current: false 
    },
];

const general = [
    { name: "Settings", href: "#", icon: CogIcon, current: false },
    { name: "Security", href: "#", icon: ShieldCheckIcon, current: false },
];

const props = defineProps({
    auth: {
        type: Object,
        required: true
    }
});

onMounted(() => {
    console.log('Auth Data:', props.auth);
    console.log('User Data:', props.auth?.user);
    console.log('User Roles:', props.auth?.user?.roles);
});

const logout = () => {
    router.post(route('logout'));
};

// Computed untuk mengecek role admin
const isAdmin = computed(() => {
    const roles = props.auth?.user?.roles || [];
    console.log('Checking admin role:', roles);
    
    if (!roles || !Array.isArray(roles)) {
        console.log('No roles or invalid roles format');
        return false;
    }
    
    const hasAdminRole = roles.includes('admin');
    console.log('Has admin role:', hasAdminRole);
    return hasAdminRole;
});

// Computed untuk user data
const userData = computed(() => {
    return props.auth?.user;
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
            <div class="flex flex-1 flex-col overflow-y-auto custom-scrollbar">
                <nav class="flex-1 px-4 py-4">
                    <!-- Dashboard Section -->
                    <div class="space-y-8">
                        <div>
                            <p class="px-2 text-sm font-semibold text-gray-400 mb-4">
                                DASHBOARD
                            </p>
                            <div class="space-y-1">
                                <template v-for="item in navigation" :key="item.name">
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

                        <!-- Admin Section -->
                        <div v-if="isAdmin">
                            <p class="px-2 text-sm font-semibold text-gray-400 mb-4">
                                ADMIN AREA
                            </p>
                            <div class="space-y-1">
                                <template v-for="item in admin" :key="item.name">
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
                    </div>
                </nav>

                <!-- Bottom Section -->
                <div class="mt-auto">
                    <!-- Logout Button -->
                    <div class="px-4 mb-2">
                        <button
                            @click="logout"
                            class="w-full text-gray-300 hover:bg-[#19376D] hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-gray-400 group-hover:text-white mr-3 flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </div>

                    <!-- User Profile -->
                    <div v-if="userData" class="border-t border-gray-700 p-4">
                        <div class="flex items-center">
                            <img
                                class="h-8 w-8 rounded-full object-cover"
                                :src="userData.avatar_url || `https://ui-avatars.com/api/?name=${encodeURIComponent(userData.name)}&background=random&color=fff`"
                                :alt="userData.name"
                            />
                            <div class="relative ml-3 flex-grow">
                                <div class="group">
                                    <button 
                                        class="flex items-center justify-between w-full text-left"
                                        @click="isProfileMenuOpen = !isProfileMenuOpen"
                                    >
                                        <div>
                                            <p class="text-sm font-medium text-white">
                                                {{ userData.name }}
                                            </p>
                                            <p class="text-xs text-gray-400">
                                                {{ userData.email }}
                                            </p>
                                        </div>
                                        <svg 
                                            class="h-5 w-5 text-gray-400" 
                                            :class="{ 'rotate-180': isProfileMenuOpen }"
                                            xmlns="http://www.w3.org/2000/svg" 
                                            viewBox="0 0 20 20" 
                                            fill="currentColor"
                                        >
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    
                                    <!-- Profile Dropdown Menu -->
                                    <div 
                                        v-show="isProfileMenuOpen"
                                        class="absolute bottom-full left-0 right-0 mb-2 bg-[#19376D] rounded-md shadow-lg py-1 z-50 transform origin-bottom-left"
                                    >
                                        <Link
                                            :href="route('profile.edit')"
                                            class="block px-4 py-2 text-sm text-gray-300 hover:bg-[#0B2447] hover:text-white transition-colors duration-150"
                                        >
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                Edit Profile
                                            </div>
                                        </Link>
                                        <button
                                            @click="logout"
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-[#0B2447] hover:text-white transition-colors duration-150"
                                        >
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                </svg>
                                                Logout
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
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
                <header class="mb-6">
                    <slot name="header" />
                </header>
                <slot />
            </main>
        </div>
    </div>
</template>

<style scoped>
.custom-scrollbar {
    scrollbar-width: thin;
    scrollbar-color: rgba(255, 255, 255, 0.2) transparent;
}

.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 2px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background-color: rgba(255, 255, 255, 0.3);
}
</style>
