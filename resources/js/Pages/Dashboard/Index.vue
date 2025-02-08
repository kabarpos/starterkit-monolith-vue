<script setup>
import { ref, onMounted } from "vue";
import { Head } from "@inertiajs/vue3";
import AppLayout from '@/Layouts/AppLayout.vue';
import {
    EllipsisHorizontalIcon,
    ArrowUpIcon,
    ArrowDownIcon,
} from "@heroicons/vue/24/outline";

// Data Statistics
const stats = {
    netIncome: {
        amount: "193.000",
        percentage: "+35%",
        isIncrease: true,
    },
    totalReturn: {
        amount: "32.000",
        percentage: "-24%",
        isIncrease: false,
    },
};

// Transaction Data
const transactions = [
    {
        id: 1,
        name: "Premium T-Shirt",
        date: "Jul 12th 2024",
        orderNumber: "QJWEJS7ISNC",
        status: "Completed",
        icon: "👕",
    },
    {
        id: 2,
        name: "Playstation 5",
        date: "Jul 12th 2024",
        orderNumber: "QJWEJS7ISNC",
        status: "Pending",
        icon: "🎮",
    },
    {
        id: 3,
        name: "Hoodie Gombrong",
        date: "Jul 12th 2024",
        orderNumber: "QJWEJS7ISNC",
        status: "Pending",
        icon: "👕",
    },
    {
        id: 4,
        name: "iPhone 15 Pro Max",
        date: "Jul 12th 2024",
        orderNumber: "QJWEJS7ISNC",
        status: "Completed",
        icon: "📱",
    },
    {
        id: 5,
        name: "Lotse",
        date: "Jul 12th 2024",
        orderNumber: "QJWEJS7ISNC",
        status: "Completed",
        icon: "☕",
    },
    {
        id: 6,
        name: "Starbucks",
        date: "Jul 12th 2024",
        orderNumber: "QJWEJS7ISNC",
        status: "Completed",
        icon: "☕",
    },
];

// Revenue Chart Data
const revenueData = {
    income: [120000, 150000, 180000, 170000, 190000, 193000],
    expenses: [80000, 100000, 110000, 100000, 120000, 115000],
    months: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
};

// Sales Report Data
const salesReport = {
    productLaunched: 233,
    ongoingProduct: 23,
    productSold: 482,
};

// Performance Data
const performanceData = {
    totalCount: "565K",
    segments: [
        { name: "Sales", percentage: 23 },
        { name: "View Count", percentage: 68 },
        { name: "Percentage", percentage: 16 },
    ],
};

defineProps({
    auth: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :auth="auth">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        You're logged in!
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
