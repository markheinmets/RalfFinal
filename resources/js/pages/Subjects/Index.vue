<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { Star } from 'lucide-vue-next'; // optional, for icon use

const form = useForm({
    title: '',
    description: '',
    image: '',
    category: '',
    rating: 1,
});

defineProps(['apiData']);
</script>

<template>
    <AppLayout>
        <div class="mx-auto max-w-6xl space-y-12 p-6">
            <!-- Header -->
            <div class="text-center">
                <h1 class="mb-2 text-4xl font-extrabold text-blue-700">🎯 My Favorite Subjects</h1>
                <p class="text-gray-500">Add, explore, and admire your favorite topics or games.</p>
            </div>

            <!-- Form Card -->
            <div class="rounded-xl border border-blue-100 bg-gradient-to-r from-white to-blue-50 p-8 shadow-xl">
                <h2 class="mb-6 text-2xl font-bold text-blue-700">➕ Add New Subject</h2>
                <form @submit.prevent="form.post(route('subjects.store'))" class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <input v-model="form.title" placeholder="Title" class="form-input" />
                    <input v-model="form.image" placeholder="Image URL" class="form-input" />
                    <textarea v-model="form.description" placeholder="Description" class="form-textarea col-span-full" />
                    <input v-model="form.category" placeholder="Category" class="form-input" />
                    <input v-model="form.rating" type="number" min="1" max="5" class="form-input" />
                    <button type="submit" class="rounded-lg bg-blue-600 py-3 text-white transition hover:bg-blue-700 md:col-span-2">Submit</button>
                </form>
            </div>

            <!-- Saved Subjects Display -->
            <div v-if="$page.props.subjects?.length" class="space-y-4">
                <h2 class="border-b pb-2 text-2xl font-bold text-green-700">💾 Saved Subjects</h2>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <div
                        v-for="subject in $page.props.subjects"
                        :key="subject.id"
                        class="rounded-xl bg-white p-5 shadow-md transition hover:shadow-xl"
                    >
                        <img v-if="subject.image" :src="subject.image" class="mb-3 h-40 w-full rounded-lg object-cover" />
                        <h3 class="text-lg font-bold text-gray-800">{{ subject.title }}</h3>
                        <p class="mb-2 text-sm text-gray-600">{{ subject.description }}</p>
                        <p class="text-sm text-gray-500"><strong>Category:</strong> {{ subject.category }}</p>
                        <p class="flex items-center gap-1 text-sm text-gray-500">
                            <strong>Rating:</strong> {{ subject.rating }}
                            <Star v-if="subject.rating > 0" class="h-4 w-4 text-yellow-400" />
                        </p>
                    </div>
                </div>
            </div>

            <!-- API Data Display -->
            <div v-if="apiData && apiData.length" class="space-y-6">
                <h2 class="border-b pb-2 text-2xl font-bold text-indigo-600">🌐 Imported from API</h2>
                <div v-for="item in apiData" :key="item.id" class="grid grid-cols-1 gap-4 rounded-xl border bg-white p-6 shadow-md md:grid-cols-3">
                    <img :src="item.image" alt="API Subject" class="h-60 w-full rounded-xl object-cover" />
                    <div class="space-y-2 md:col-span-2">
                        <h3 class="text-xl font-semibold text-gray-800">{{ item.title }}</h3>
                        <p class="text-gray-600">{{ item.description }}</p>
                        <p class="text-sm text-gray-500"><strong>Genres:</strong> {{ JSON.parse(item.genres).join(', ') }}</p>
                        <p class="text-sm text-gray-500"><strong>Developer:</strong> {{ item.developer }}</p>
                    </div>
                </div>
            </div>

            
        </div>
    </AppLayout>
</template>

<style scoped>
.form-input {
    @apply w-full rounded-lg border border-gray-300 p-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500;
}
.form-textarea {
    @apply h-32 w-full rounded-lg border border-gray-300 p-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500;
}
</style>
