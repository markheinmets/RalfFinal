<script setup lang="ts">
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardDescription from '@/components/ui/card/CardDescription.vue';
import CardFooter from '@/components/ui/card/CardFooter.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import Dialog from '@/components/ui/dialog/Dialog.vue';
import DialogContent from '@/components/ui/dialog/DialogContent.vue';
import DialogDescription from '@/components/ui/dialog/DialogDescription.vue';
import DialogHeader from '@/components/ui/dialog/DialogHeader.vue';
import DialogTitle from '@/components/ui/dialog/DialogTitle.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { MapMouseEvent } from 'maplibre-gl';
import Radar from 'radar-sdk-js';
import 'radar-sdk-js/dist/radar.css';
import { onMounted, ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

defineProps(['weather']);

const show = ref(false);

const mapMouseEv = ref<MapMouseEvent>();

Radar.initialize('prj_test_pk_9420a9d7d27cdfeddbe3bd3ce05202c5c3d1cac5', {
    /* map config options */
});

onMounted(() => {
    const map = Radar.ui.map({
        container: 'map',
        style: 'radar-dark-v1',
        center: [22.488819593503443, 58.25398239259826],
        zoom: 14,
    });

    map.on('click', (e) => {
        mapMouseEv.value = e;
        show.value = true;
    });

    Radar.ui
        .marker({
            color: '#000257',
            width: 40,
            height: 80,
            popup: {
                text: 'My popup.',
            },
        })
        .setLngLat([-73.99055, 40.735225])
        .addTo(map.value);
});
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
               
                <Card>
                    <CardHeader class="flex h-16 flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium"> Weather </CardTitle>
                        <img :src="'http://openweathermap.org/img/wn/' + weather.weather[0].icon + '@2x.png'" alt="Weather icon" class="h-12 w-12" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ weather.main.temp }}°C</div>
                        <p class="text-xs text-muted-foreground">{{ weather.wind.speed }} m/s ( {{ weather.weather[0].description }} )</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle>Card Title</CardTitle>
                        <CardDescription>Card Description</CardDescription>
                    </CardHeader>
                    <CardContent> Card Content </CardContent>
                    <CardFooter> Card Footer </CardFooter>
                </Card>
                <Card>
                    <CardHeader>
                        <CardTitle>Card Title</CardTitle>
                        <CardDescription>Card Description</CardDescription>
                    </CardHeader>
                    <CardContent> Card Content </CardContent>
                    <CardFooter> Card Footer </CardFooter>
                </Card>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <div id="map" style="width: 100%; height: 100%" />
            </div>
        </div>

        <Dialog :open="show" @update:open="show = $event">
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>marker stuff</DialogTitle>
                    <DialogDescription>
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Maiores quod libero repellat praesentium corporis natus cumque porro
                        dolorem voluptate totam!
                    </DialogDescription>
                </DialogHeader>

                <div>
                    <p>Latitude: {{ mapMouseEv?.lngLat.lat }}</p>
                    <p>Longitude: {{ mapMouseEv?.lngLat.lng }}</p>
                </div>
            </DialogContent>
        </Dialog>
    </AppLayout>
</template>
