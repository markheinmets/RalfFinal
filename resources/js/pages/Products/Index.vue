<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Link as InertiaLink } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import axios from 'axios';

const props = defineProps<{ products: any[]; cart?: Record<number, any> }>();

const quantities = ref<{ [key: number]: number }>({});

const addToCart = async (productId: number) => {
    const quantity = quantities.value[productId] || 1;

    try {
        const response = await axios.post(route('cart.add', { productId }), {
            quantity,
        });

        // Optional: update cart state dynamically if needed
        console.log('Added to cart:', response.data.cart);
    } catch (error) {
        console.error('Error adding to cart:', error);
    }
};

const totalPrice = computed(() => {
    if (!props.cart) return 0;
    return Object.values(props.cart).reduce((sum: number, item: any) => sum + item.price * item.quantity, 0);
});
</script>

<template>
    <AppLayout>
        <div class="mx-auto my-12 w-full max-w-6xl px-4">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-3xl font-bold">E-Store</h1>

                <InertiaLink :href="route('cart.index')">
                    <Button variant="outline">View Cart</Button>
                </InertiaLink>
            </div>

            <div v-if="props.cart && Object.keys(props.cart).length > 0" class="mb-6 text-right text-lg text-gray-700">
                Cart Total: €{{ totalPrice.toFixed(2) }}
            </div>

            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="product in props.products"
                    :key="product.id"
                    class="flex flex-col rounded-xl border bg-white p-4 shadow-sm"
                >
                    <div class="relative h-48 w-full overflow-hidden rounded">
                        <img :src="product.image" alt="Product Image" class="product-image h-full w-full object-cover" />
                    </div>

                    <h2 class="mt-4 text-lg font-semibold">{{ product.name }}</h2>
                    <p class="mt-1 text-sm text-gray-600">{{ product.description }}</p>
                    <p class="mt-2 text-base font-medium text-gray-900">€{{ product.price }}</p>

                    <input
                        type="number"
                        min="1"
                        v-model.number="quantities[product.id]"
                        placeholder="Quantity"
                        class="mt-3 w-full rounded border px-3 py-2 text-sm"
                    />

                    <Button class="mt-4" @click="addToCart(product.id)">Add to Cart</Button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.product-image {
    aspect-ratio: 1 / 1;
    object-fit: cover;
}
</style>
