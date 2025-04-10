<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Show post',
        href: '/posts/show',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div>show</div>
    </AppLayout>
</template>
