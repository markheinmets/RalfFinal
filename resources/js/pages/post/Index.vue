<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps(['posts']);

const deletePost = (id: number) => {
    if (confirm('Are you sure you want to delete this post?')) {
        router.delete(route('posts.destroy', id));
    }
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Posts',
        href: '/posts',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto mt-10 max-w-4xl">
            <div class="mb-6 flex justify-between">
                <h1 class="text-2xl font-semibold">Posts</h1>
                <Link :href="route('posts.create')">
                    <Button>Create Post</Button>
                </Link>
            </div>

            <div v-if="posts.length">
                <div v-for="post in posts" :key="post.id" class="mb-4 rounded-lg border p-4 shadow-sm">
                    <h2 class="text-lg font-bold">{{ post.title }}</h2>
                    <p class="mb-2 text-sm text-gray-600">{{ post.description }}</p>
                    <div class="mt-2 flex gap-3">
                        <Link :href="route('posts.show', post.id)">
                            <Button size="sm">View</Button>
                        </Link>
                        <Link :href="route('posts.edit', post.id)">
                            <Button variant="outline" size="sm">Edit</Button>
                        </Link>
                        <Button variant="destructive" size="sm" @click="deletePost(post.id)">Delete</Button>
                    </div>
                </div>
            </div>
            <p v-else class="text-gray-500">No posts found.</p>
        </div>
    </AppLayout>
</template>
