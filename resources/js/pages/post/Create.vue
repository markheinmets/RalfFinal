<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create post',
        href: '/posts/create',
    },
];

const form = useForm({
    title: '',
    description: ''
})

const submit = () => {
    form.post(route('posts.store'))
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto my-12 w-full max-w-2xl">
            <form @submit.prevent="submit">
                <Card>
                    <CardHeader>
                        <CardTitle>Create post</CardTitle>
                        <CardDescription>Create a new blog post</CardDescription>
                    </CardHeader>
                    <CardContent class="flex flex-col gap-4">
                        <div>
                            <Label>Title</Label>
                            <Input v-model="form.title" />
                            <InputError :message="form.errors.title" />
                        </div>
                        <div>
                            <Label>Description</Label>
                            <Textarea v-model="form.description" />
                            <InputError :message="form.errors.description" />
                        </div>
                    </CardContent>
                    <CardFooter>
                        <Button type="submit">Submit</Button>
                    </CardFooter>
                </Card>
            </form>
        </div>
    </AppLayout>
</template>
