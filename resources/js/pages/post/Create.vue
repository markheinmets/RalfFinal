<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create post',
        href: '/posts/create',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div>Create</div>
    </AppLayout>
</template>
