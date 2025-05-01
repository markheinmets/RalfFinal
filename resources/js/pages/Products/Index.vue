<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { usePage } from '@inertiajs/vue3';
import { CartItem } from '@/types';
import { useForm } from '@inertiajs/vue3';

const page = usePage();
const products = defineProps<{ products: any[] }>();  // Prop for the products passed from controller

const cartForm = useForm({
    product_id: null,
    quantity: 1,
});

const addToCart = (productId: number) => {
    cartForm.product_id = productId;
    cartForm.quantity = 1; // Default quantity is 1
    cartForm.post(route('cart.add', { productId }), {
        preserveScroll: true,
        onSuccess: () => {
            // Optionally display a success message or update UI
        },
    });
};
</script>

<template>
    <AppLayout>
        <div class="mx-auto my-12 w-full max-w-4xl">
            <h1 class="text-3xl font-semibold tracking-wide">E-Store</h1>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-8">
                <div v-for="product in products" :key="product.id" class="border rounded-lg p-4 shadow-sm">
                    <img :src="product.image" alt="Product Image" class="w-full h-48 object-cover rounded-t-lg" />
                    <div class="mt-4">
                        <h2 class="text-xl font-semibold">{{ product.name }}</h2>
                        <p class="text-gray-600 mt-2">{{ product.description }}</p>
                        <p class="mt-4 text-xl font-medium text-gray-900">${{ product.price }}</p>

                        <Button class="mt-4 w-full" @click="addToCart(product.id)">
                            Add to Cart
                        </Button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
