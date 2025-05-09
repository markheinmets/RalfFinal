<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { loadStripe } from '@stripe/stripe-js';
import { onMounted, ref } from 'vue';

const stripePromise = loadStripe('pk_test_51RModQKdKbPW0i6NZ9VkEhGYIPBh1Op2IFPjdZwwMHWyuZCCiJgnl2yZavs8b594LCevhnbezgOE8YT7egBrx3Zx00JBmfmZ2V'); // Your Stripe Publishable Key

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    payment_method: '', // This will hold the Stripe payment method ID
});

const cardElement = ref<any>(null); // Stripe Element reference

const submit = async () => {
    const stripe = await stripePromise;

    // Create a PaymentMethod with Stripe Elements
    const { error, paymentMethod } = await stripe.createPaymentMethod({
        type: 'card',
        card: cardElement.value, // Link to Stripe Element
    });

    if (error) {
        // Handle error
        console.error(error);
    } else {
        form.payment_method = paymentMethod.id; // Set payment method ID

        // Proceed with form submission
        form.post(route('checkout.process'), {
            preserveScroll: true,
        });
    }
};

onMounted(async () => {
    const stripe = await stripePromise;
    const elements = stripe.elements();
    cardElement.value = elements.create('card');
    cardElement.value.mount('#card-element');
});
</script>

<template>
    <AppLayout>
        <div class="mx-auto my-12 w-full max-w-2xl px-4">
            <h1 class="mb-6 text-3xl font-bold">Checkout</h1>

            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <label for="first_name" class="block font-semibold">First Name</label>
                    <input v-model="form.first_name" type="text" id="first_name" class="w-full rounded border p-2" required />
                </div>

                <div>
                    <label for="last_name" class="block font-semibold">Last Name</label>
                    <input v-model="form.last_name" type="text" id="last_name" class="w-full rounded border p-2" required />
                </div>

                <div>
                    <label for="email" class="block font-semibold">Email</label>
                    <input v-model="form.email" type="email" id="email" class="w-full rounded border p-2" required />
                </div>

                <div>
                    <label for="phone" class="block font-semibold">Phone</label>
                    <input v-model="form.phone" type="tel" id="phone" class="w-full rounded border p-2" required />
                </div>

                <!-- Stripe Element -->
                <div id="card-element"></div>
                <!-- This is where the card input will appear -->

                <Button type="submit" class="w-full bg-blue-600 text-white">Pay Now</Button>
            </form>
        </div>
    </AppLayout>
</template>
