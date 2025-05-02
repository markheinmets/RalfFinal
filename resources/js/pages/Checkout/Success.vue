<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
</script>

<template>
    <AppLayout>
        <div class="mx-auto my-20 w-full max-w-2xl px-4 text-center">
            <h1 class="mb-4 text-3xl font-bold text-green-600">Payment Successful</h1>
            <p class="text-lg text-gray-700">Thank you for your order!</p>
            <Button class="mt-6 bg-blue-600 text-white" @click="$inertia.visit('/products')"> Return to Store </Button>
        </div>
    </AppLayout>
</template>
