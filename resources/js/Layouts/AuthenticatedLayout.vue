<script setup>
import { ref, computed, onMounted } from "vue";
import { Link, router } from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import {
    ChartBarIcon,
    UserGroupIcon,
    ShieldCheckIcon,
} from "@heroicons/vue/24/outline";
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import DarkModeToggle from '@/Components/DarkModeToggle.vue';
import { Head } from "@inertiajs/vue3";

const isSidebarOpen = ref(false);
const isProfileMenuOpen = ref(false);
const showingNavigationDropdown = ref(false);

// Navigation Links
const navigation = [
    { name: "Overview", href: "/dashboard", icon: ChartBarIcon, current: true },
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

const props = defineProps({
    auth: {
        type: Object,
        required: true
    },
    title: {
        type: String,
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
    <Head :title="title" />

    <div class="min-h-screen bg-[var(--bg-gradient)] animated-gradient">
        <!-- Sidebar -->
        <div
            class="fixed inset-y-0 w-64 flex-col bg-[var(--card-gradient)] backdrop-blur-xl border-r border-[var(--border-primary)] shadow-lg transition-all duration-300"
            :class="{ 'hidden md:flex': !isSidebarOpen, flex: isSidebarOpen }"
        >
            <!-- Sidebar header -->
            <div class="flex h-16 shrink-0 items-center px-6 border-b border-[var(--border-primary)]">
                <ApplicationLogo class="h-8 w-auto transition-transform hover:scale-105" />
                <span class="ml-2 text-xl font-semibold text-[var(--text-primary)]">Siohioma</span>
            </div>

            <!-- Sidebar content -->
            <div class="flex flex-1 flex-col overflow-y-auto custom-scrollbar">
                <nav class="flex-1 px-4 py-4">
                    <!-- Dashboard Section -->
                    <div class="space-y-8">
                        <div>
                            <p class="px-2 text-sm font-semibold text-[var(--text-secondary)] mb-4">
                                DASHBOARD
                            </p>
                            <div class="space-y-1">
                                <template v-for="item in navigation" :key="item.name">
                                    <Link
                                        :href="item.href"
                                        :class="[
                                            item.current
                                                ? 'bg-[var(--primary-50)] dark:bg-[var(--primary-900)]/20 text-[var(--primary-600)] dark:text-[var(--primary-400)]'
                                                : 'text-[var(--text-primary)] hover:bg-[var(--bg-secondary)]/50',
                                            'group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-colors duration-150',
                                        ]"
                                    >
                                        <component
                                            :is="item.icon"
                                            :class="[
                                                item.current
                                                    ? 'text-[var(--primary-600)] dark:text-[var(--primary-400)]'
                                                    : 'text-[var(--text-secondary)] group-hover:text-[var(--text-primary)]',
                                                'mr-3 flex-shrink-0 h-6 w-6 transition-colors duration-150',
                                            ]"
                                        />
                                        {{ item.name }}
                                        <span
                                            v-if="item.count"
                                            class="ml-auto inline-block py-0.5 px-2 text-xs rounded-full bg-[var(--primary-100)] dark:bg-[var(--primary-900)]/30 text-[var(--primary-600)] dark:text-[var(--primary-400)]"
                                        >
                                            {{ item.count }}
                                        </span>
                                    </Link>
                                </template>
                            </div>
                        </div>

                        <!-- Admin Section -->
                        <div v-if="isAdmin">
                            <p class="px-2 text-sm font-semibold text-[var(--text-secondary)] mb-4">
                                ADMIN AREA
                            </p>
                            <div class="space-y-1">
                                <template v-for="item in admin" :key="item.name">
                                    <Link
                                        :href="item.href"
                                        class="text-[var(--text-primary)] hover:bg-[var(--bg-secondary)]/50 group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-colors duration-150"
                                    >
                                        <component
                                            :is="item.icon"
                                            class="text-[var(--text-secondary)] group-hover:text-[var(--text-primary)] mr-3 flex-shrink-0 h-6 w-6 transition-colors duration-150"
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
                    <!-- User Profile -->
                    <div v-if="userData" class="border-t border-[var(--border-primary)] p-4">
                        <div class="flex items-center">
                            <img
                                class="h-8 w-8 rounded-full object-cover ring-2 ring-[var(--bg-secondary)] dark:ring-[var(--neutral-700)]"
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
                                            <p class="text-sm font-medium text-[var(--text-primary)]">
                                                {{ userData.name }}
                                            </p>
                                            <p class="text-xs text-[var(--text-secondary)]">
                                                {{ userData.email }}
                                            </p>
                                        </div>
                                        <svg 
                                            class="h-5 w-5 text-[var(--text-secondary)] transition-transform duration-200" 
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
                                        class="absolute bottom-full left-0 right-0 mb-2 bg-[var(--card-gradient)] rounded-lg shadow-lg py-1 border border-[var(--border-primary)]"
                                    >
                                        <Link
                                            :href="route('profile.edit')"
                                            class="block px-4 py-2 text-sm text-[var(--text-primary)] hover:bg-[var(--bg-secondary)]/50 transition-colors duration-150"
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
                                            class="block w-full text-left px-4 py-2 text-sm text-[var(--text-primary)] hover:bg-[var(--bg-secondary)]/50 transition-colors duration-150"
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
        <div class="md:pl-64 min-h-screen">
            <!-- Top header -->
            <div class="sticky top-0 z-10 bg-[var(--card-gradient)] backdrop-blur-xl border-b border-[var(--border-primary)] shadow-sm transition-all duration-300 md:hidden">
                <div class="flex h-16 items-center justify-between px-6">
                    <button
                        @click="isSidebarOpen = !isSidebarOpen"
                        class="rounded-lg p-2 text-[var(--text-secondary)] hover:bg-[var(--bg-secondary)]/50 focus:outline-none"
                    >
                        <span class="sr-only">Open sidebar</span>
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <ApplicationLogo class="h-8 w-auto" />
                </div>
            </div>

            <!-- Page content -->
            <main class="py-6 px-6">
                <header v-if="$slots.header" class="mb-6">
                    <slot name="header" />
                </header>
                <div class="transition-all duration-300">
                    <slot />
                </div>
            </main>
        </div>

        <!-- Dark Mode Toggle -->
        <DarkModeToggle />
    </div>
</template>

<style scoped>
.custom-scrollbar {
    scrollbar-width: thin;
    scrollbar-color: rgba(203, 213, 225, 0.2) transparent;
}

.dark .custom-scrollbar {
    scrollbar-color: rgba(51, 65, 85, 0.2) transparent;
}

.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: rgba(203, 213, 225, 0.2);
    border-radius: 2px;
}

.dark .custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: rgba(51, 65, 85, 0.2);
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background-color: rgba(203, 213, 225, 0.3);
}

.dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background-color: rgba(51, 65, 85, 0.3);
}

/* Tambahkan animasi gradient */
@keyframes gradient {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

.bg-\[var\(--bg-gradient\)\] {
    background-size: 400% 400%;
    animation: gradient 15s ease infinite;
}
</style>
