<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

const form = useForm({
    title: '',
    description: '',
    image: '',
    category: '',
    rating: 1,
});
</script>

<template>
    <AppLayout>
    <div class="p-6">
      <h1 class="mb-4 text-2xl font-bold">Add Favorite Subject</h1>
      <form @submit.prevent="form.post(route('subjects.store'))" class="space-y-4">
        <input v-model="form.title" placeholder="Title" class="w-full border p-2" />
        <textarea v-model="form.description" placeholder="Description" class="w-full border p-2"></textarea>
        <input v-model="form.image" placeholder="Image URL" class="w-full border p-2" />
        <input v-model="form.category" placeholder="Category" class="w-full border p-2" />
        <input v-model="form.rating" type="number" min="1" max="5" class="w-full border p-2" />
        <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white">Submit</button>
      </form>

      <h2 class="mt-8 text-xl font-bold">Subjects List</h2>
      <div v-for="subject in $page.props.subjects" :key="subject.id" class="mt-4 border p-4">
        <h3 class="text-lg font-semibold">{{ subject.title }}</h3>
        <p>{{ subject.description }}</p>
        <p><strong>Category:</strong> {{ subject.category }}</p>
        <p><strong>Rating:</strong> {{ subject.rating }}/5</p>
        <img v-if="subject.image" :src="subject.image" class="mt-2 w-32" />
      </div>
    </div>
  </AppLayout>
</template>

