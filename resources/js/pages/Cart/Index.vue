<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps<{
    cart: Record<number, any>;
    products: any[];
}>();

const form = useForm({
    productId: null,
    quantity: 1,
});

const totalPrice = computed(() => {
    let total = 0;
    for (const item of Object.values(props.cart)) {
        total += item.price * item.quantity;
    }
    return total;
});

// Update the cart quantity
const updateQuantity = (productId: number, quantity: number) => {
    form.productId = productId;
    form.quantity = quantity;

    form.post(route('cart.update', { productId }), {
        preserveScroll: true,
        onSuccess: (data) => {
            props.cart = data.cart; // Update the cart dynamically
        },
    });
};

// Remove product from the cart
const removeFromCart = (productId: number) => {
    form.productId = productId;

    form.delete(route('cart.remove', { productId }), {
        preserveScroll: true,
        onSuccess: (data) => {
            // Update the cart dynamically from the response
            props.cart = data.cart; // Ensure you're getting the correct cart data from Inertia's response
        },
    });
};

// Proceed to checkout
const proceedToCheckout = () => {
    window.location.href = '/checkout';
};
</script>

<template>
    <AppLayout>
        <div class="mx-auto my-12 w-full max-w-6xl px-4">
            <h1 class="mb-6 text-3xl font-bold">Your Cart</h1>

            <!-- Cart Items -->
            <div v-if="Object.keys(props.cart).length > 0">
                <div
                    v-for="(item, productId) in props.cart"
                    :key="productId"
                    class="mb-6 flex items-center justify-between rounded-lg border p-4 shadow-sm"
                >
                    <div class="flex items-center">
                        <img :src="item.image" alt="Product Image" class="h-16 w-16 rounded object-cover" />
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold">{{ item.name }}</h3>
                            <p class="text-gray-600">{{ item.description }}</p>
                            <p class="text-gray-600">€{{ item.price }}</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">
                        <input
                            type="number"
                            min="1"
                            v-model.number="item.quantity"
                            @change="updateQuantity(productId, item.quantity)"
                            class="w-16 rounded-md border p-2"
                        />
                        <Button @click="removeFromCart(productId)" class="rounded-md bg-red-600 p-2 text-white">Remove</Button>
                    </div>

                    <div class="ml-4">
                        <p class="font-medium">Subtotal: €{{ (item.price * item.quantity).toFixed(2) }}</p>
                    </div>
                </div>

                <!-- Cart Total -->
                <div class="text-right text-lg font-semibold">Total: €{{ totalPrice.toFixed(2) }}</div>

                <!-- Proceed to Checkout -->
                <Button class="mt-6 bg-blue-600 text-white" @click="proceedToCheckout"> Proceed to Checkout </Button>
            </div>

            <!-- Empty Cart Message -->
            <div v-else class="text-center text-lg text-gray-600">Your cart is empty.</div>
        </div>
    </AppLayout>
</template>

<style scoped>
.product-image {
    aspect-ratio: 1 / 1;
    object-fit: cover;
}
</style>
