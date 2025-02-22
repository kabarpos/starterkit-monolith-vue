<script setup>
import { Link } from "@inertiajs/vue3";
import {
    ChartBarIcon,
    UserGroupIcon,
    ShieldCheckIcon,
    Cog6ToothIcon
} from "@heroicons/vue/24/outline";

const adminNavigation = [
    { 
        name: "User Management", 
        href: route('admin.users.index'), 
        icon: UserGroupIcon
    },
    { 
        name: "Role Management", 
        href: route('admin.roles.index'), 
        icon: ShieldCheckIcon
    },
    { 
        name: "Website Settings", 
        href: route('admin.settings.index'), 
        icon: Cog6ToothIcon
    }
];
</script>

<template>
    <div>
        <p class="px-3 text-xs font-medium text-light-text/60 dark:text-dark-text/60 uppercase tracking-wider">
            Admin Area
        </p>
        <div class="mt-2 space-y-1">
            <Link
                v-for="item in adminNavigation"
                :key="item.name"
                :href="item.href"
                class="flex items-center px-3 py-2 text-sm text-light-text dark:text-dark-text hover:text-primary-500 hover:bg-primary-50 dark:hover:bg-primary-500/10 rounded-lg transition-colors"
            >
                <component
                    :is="item.icon"
                    class="h-5 w-5 mr-2"
                />
                {{ item.name }}
            </Link>
        </div>
    </div>
</template> 