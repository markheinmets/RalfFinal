<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';

const goBackToCart = () => {
    router.visit('/cart');
};
</script>

<template>
    <AppLayout>
        <div class="mx-auto mt-20 max-w-xl text-center">
            <h1 class="mb-4 text-3xl font-bold text-red-600">Payment Failed</h1>
            <p class="mb-6 text-gray-700">Something went wrong. Your cart is still available.</p>
            <button @click="goBackToCart" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">Try Again</button>
        </div>
    </AppLayout>
</template>
