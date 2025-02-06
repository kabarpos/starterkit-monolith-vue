<script setup>
import { ref, onMounted } from "vue";
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
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
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <!-- Header & Period Selector -->
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-xl md:text-2xl font-semibold text-gray-900">
                        Dashboard
                    </h1>
                    <p class="text-gray-500 mt-1">
                        An any way to manage sales with care and precision.
                    </p>
                </div>
            </div>

            <!-- Update Card -->
            <div class="bg-[#0B2447] rounded-lg p-6 text-white w-full">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="flex items-center space-x-2">
                            <span
                                class="bg-red-500 h-2 w-2 rounded-full"
                            ></span>
                            <span class="text-sm">Update</span>
                        </div>
                        <p class="mt-4 text-2xl font-semibold">
                            Sales revenue increased
                        </p>
                        <p class="mt-1">
                            <span class="text-green-400 font-semibold"
                                >40%</span
                            >
                            in 1 week
                        </p>
                    </div>
                    <button class="text-sm text-blue-400 hover:text-blue-300">
                        See Statistics
                    </button>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Net Income -->
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-gray-500">Net Income</h3>
                            <div class="mt-2 flex items-baseline">
                                <span class="text-3xl font-semibold">$</span>
                                <span class="text-4xl font-semibold">{{
                                    stats.netIncome.amount
                                }}</span>
                            </div>
                            <div class="mt-2 flex items-center">
                                <ArrowUpIcon
                                    v-if="stats.netIncome.isIncrease"
                                    class="h-4 w-4 text-green-500"
                                />
                                <ArrowDownIcon
                                    v-else
                                    class="h-4 w-4 text-red-500"
                                />
                                <span
                                    :class="
                                        stats.netIncome.isIncrease
                                            ? 'text-green-500'
                                            : 'text-red-500'
                                    "
                                    class="ml-1"
                                >
                                    {{ stats.netIncome.percentage }}
                                </span>
                                <span class="ml-1 text-gray-500"
                                    >from last month</span
                                >
                            </div>
                        </div>
                        <button>
                            <EllipsisHorizontalIcon
                                class="h-6 w-6 text-gray-400"
                            />
                        </button>
                    </div>
                </div>

                <!-- Total Return -->
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-gray-500">Total Return</h3>
                            <div class="mt-2 flex items-baseline">
                                <span class="text-3xl font-semibold">$</span>
                                <span class="text-4xl font-semibold">{{
                                    stats.totalReturn.amount
                                }}</span>
                            </div>
                            <div class="mt-2 flex items-center">
                                <ArrowUpIcon
                                    v-if="stats.totalReturn.isIncrease"
                                    class="h-4 w-4 text-green-500"
                                />
                                <ArrowDownIcon
                                    v-else
                                    class="h-4 w-4 text-red-500"
                                />
                                <span
                                    :class="
                                        stats.totalReturn.isIncrease
                                            ? 'text-green-500'
                                            : 'text-red-500'
                                    "
                                    class="ml-1"
                                >
                                    {{ stats.totalReturn.percentage }}
                                </span>
                                <span class="ml-1 text-gray-500"
                                    >from last month</span
                                >
                            </div>
                        </div>
                        <button>
                            <EllipsisHorizontalIcon
                                class="h-6 w-6 text-gray-400"
                            />
                        </button>
                    </div>
                </div>
            </div>

            <!-- Transactions and Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Transactions List -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Transaction</h3>
                        <button>
                            <EllipsisHorizontalIcon
                                class="h-6 w-6 text-gray-400"
                            />
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div
                            v-for="transaction in transactions"
                            :key="transaction.id"
                            class="flex items-center justify-between py-3 border-b last:border-0"
                        >
                            <div class="flex items-center space-x-4">
                                <span class="text-2xl">{{
                                    transaction.icon
                                }}</span>
                                <div>
                                    <p class="font-medium">
                                        {{ transaction.name }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ transaction.date }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p
                                    :class="[
                                        'text-sm font-medium',
                                        transaction.status === 'Completed'
                                            ? 'text-green-600'
                                            : 'text-yellow-600',
                                    ]"
                                >
                                    {{ transaction.status }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ transaction.orderNumber }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revenue Chart -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Revenue</h3>
                        <button>
                            <EllipsisHorizontalIcon
                                class="h-6 w-6 text-gray-400"
                            />
                        </button>
                    </div>

                    <div class="h-64">
                        <!-- Add your chart component here -->
                        <!-- You can use Chart.js, ApexCharts, or any other charting library -->
                    </div>
                </div>
            </div>

            <!-- Sales Report Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Sales Report</h3>
                        <button>
                            <EllipsisHorizontalIcon
                                class="h-6 w-6 text-gray-400"
                            />
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span>Product Launched</span>
                                <span class="text-green-600"
                                    >({{ salesReport.productLaunched }})</span
                                >
                            </div>
                            <div class="h-2 bg-green-100 rounded-full">
                                <div
                                    class="h-full bg-green-500 rounded-full"
                                    style="width: 60%"
                                ></div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span>Ongoing Product</span>
                                <span class="text-yellow-600"
                                    >({{ salesReport.ongoingProduct }})</span
                                >
                            </div>
                            <div class="h-2 bg-yellow-100 rounded-full">
                                <div
                                    class="h-full bg-yellow-500 rounded-full"
                                    style="width: 30%"
                                ></div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span>Product Sold</span>
                                <span class="text-blue-600"
                                    >({{ salesReport.productSold }})</span
                                >
                            </div>
                            <div class="h-2 bg-blue-100 rounded-full">
                                <div
                                    class="h-full bg-blue-500 rounded-full"
                                    style="width: 85%"
                                ></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Performance Donut Chart -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">
                            Total View Performance
                        </h3>
                        <button>
                            <EllipsisHorizontalIcon
                                class="h-6 w-6 text-gray-400"
                            />
                        </button>
                    </div>

                    <div class="flex items-center justify-center">
                        <!-- Add your donut chart component here -->
                        <!-- You can use Chart.js, ApexCharts, or any other charting library -->
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
