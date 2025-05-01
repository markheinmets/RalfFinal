<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import Input from '@/components/ui/input/Input.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import Button from '@/components/ui/button/Button.vue';
import { BreadcrumbItem } from '@/types';

const props = defineProps(['post']);

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Edit Post', href: '/posts/edit' },
];

const form = useForm({
    title: props.post.title,
    description: props.post.description,
});

const submit = () => {
    form.put(route('posts.update', props.post.id));
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="max-w-2xl mx-auto mt-12">
            <form @submit.prevent="submit" class="space-y-4">
                <Input v-model="form.title" placeholder="Post Title" />
                <Textarea v-model="form.description" placeholder="Post Content" />
                <Button type="submit">Update Post</Button>
            </form>
        </div>
    </AppLayout>
</template>
