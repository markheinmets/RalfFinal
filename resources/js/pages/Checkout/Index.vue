<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
});

const submit = () => {
    form.post(route('checkout.process'), {
        preserveScroll: true,
    });
};
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

                <Button type="submit" class="w-full bg-blue-600 text-white">Pay Now</Button>
            </form>
        </div>
    </AppLayout>
</template>
