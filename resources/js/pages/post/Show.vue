<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { useForm, usePage } from '@inertiajs/vue3';

const page = usePage();
const props = defineProps(['post']);

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Show post', href: '/posts/show' }];

const form = useForm({
    comment: '',
});

const submit = () => {
    form.post(route('comments.store', props.post), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto my-12 w-full max-w-2xl">
            <div>
                <h1 class="text-2xl font-semibold tracking-wide">{{ post.title }}</h1>
                <p>{{ post.description }}</p>
            </div>

            <div class="mt-8">
                <form @submit.prevent="submit">
                    <div class="relative">
                        <Textarea v-model="form.comment" class="h-full w-full" />
                        <Button class="absolute bottom-4 right-4 z-10">Submit</Button>
                    </div>
                </form>
            </div>

            <div class="mt-8">
                <h2 class="text-lg font-semibold">Comments</h2>
                <div v-if="post.comments.length" class="mt-4 space-y-4">
                    <div v-for="comment in post.comments" :key="comment.id" class="relative rounded-lg border p-4 shadow-sm">
                        <p class="text-sm text-gray-500">
                            <span class="font-medium">{{ comment.user.name }}</span>
                            – {{ comment.created_at_for_humans }}
                        </p>
                        <p class="mt-2">{{ comment.comment }}</p>

                        <!-- Admin Delete Button -->
                        <Button
                            v-if="$page.props.auth.user?.is_admin"
                            class="absolute right-4 top-4 text-red-500 hover:text-red-700"
                            variant="ghost"
                            @click="$inertia.delete(route('comments.destroy', comment.id), { preserveScroll: true })"
                        >
                            Delete
                        </Button>
                    </div>
                </div>
                <p v-else class="mt-4 text-gray-500">No comments yet.</p>
            </div>
        </div>
    </AppLayout>
</template>
