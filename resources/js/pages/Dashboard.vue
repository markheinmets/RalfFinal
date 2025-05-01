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
import { ref, onMounted } from 'vue';
import axios from 'axios';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

defineProps(['weather']);

const showAddDialog = ref(false); // Dialog visibility for adding a new marker
const showEditDialog = ref(false); // Dialog visibility for editing an existing marker
const mapMouseEv = ref<MapMouseEvent>(); // Store the mouse event with lat/lng
const markerName = ref(''); // New marker name
const markerDescription = ref(''); // New marker description
const markers = ref<any[]>([]); // Store all markers fetched from the server
const selectedMarker = ref<any>(null); // Store the marker to edit or delete
const mapMarkers = ref<any[]>([]); // Store the map markers to remove and re-add them

let map: any; // Store the map reference

// Radar map initialization
Radar.initialize('prj_test_pk_9420a9d7d27cdfeddbe3bd3ce05202c5c3d1cac5', {});

onMounted(() => {
    map = Radar.ui.map({
        container: 'map',
        style: 'radar-dark-v1',
        center: [22.488819593503443, 58.25398239259826],
        zoom: 14,
    });

    map.on('click', (e) => {
        mapMouseEv.value = e; // Store the map click event
        showAddDialog.value = true; // Open dialog to add a new marker
    });

    // Fetch initial markers
    fetchMarkers(map);
});

// Fetch markers from the server and add them to the map
const fetchMarkers = async (map: any) => {
    try {
        const response = await axios.get('/markers'); // Replace with your correct backend endpoint
        markers.value = response.data; // Store fetched markers

        // Remove any old markers from the map before re-adding
        mapMarkers.value.forEach((mapMarker) => {
            mapMarker.remove();
        });
        mapMarkers.value = [];

        // Loop through markers and add them to the map
        markers.value.forEach((marker: any) => {
            const mapMarker = Radar.ui.marker({
                color: '#FF5733',
                width: 40,
                height: 80,
                popup: {
                    text: marker.name,
                },
            })
            .setLngLat([marker.longitude, marker.latitude])
            .addTo(map);

            // Add the map marker to the mapMarkers array for later removal
            mapMarkers.value.push(mapMarker);

            // Add click event to marker for edit/delete
            mapMarker.getElement().addEventListener('click', () => {
                selectedMarker.value = marker;
                markerName.value = marker.name; // Pre-fill name
                markerDescription.value = marker.description; // Pre-fill description
                showEditDialog.value = true; // Open the edit dialog
            });
        });
    } catch (error) {
        console.error('Error fetching markers:', error);
    }
};

// Handle marker submission for new marker
const submitMarker = async () => {
    if (!mapMouseEv.value) return; // Ensure there is a valid mouse event

    const lat = mapMouseEv.value.lngLat.lat;
    const lng = mapMouseEv.value.lngLat.lng;
    const name = markerName.value || 'New Marker'; // Default name, could be dynamic
    const description = markerDescription.value || 'A new marker added via the map click.'; // Default description

    try {
        // Post the new marker to the server
        const response = await axios.post('/markers', { name, description, latitude: lat, longitude: lng });
        
        // Add the new marker to the state and refresh the map
        markers.value.push(response.data);

        // Re-render the marker on the map using the stored map reference
        const mapMarker = Radar.ui.marker({
            color: '#FF5733',
            width: 40,
            height: 80,
            popup: { text: response.data.name },
        })
        .setLngLat([response.data.longitude, response.data.latitude])
        .addTo(map);

        // Add the map marker to the mapMarkers array
        mapMarkers.value.push(mapMarker);

        // Close the dialog after submitting the marker
        showAddDialog.value = false;
    } catch (error) {
        console.error('Error adding marker:', error);
    }
};

// Handle marker editing
const updateMarker = async () => {
    if (!selectedMarker.value) return; // Ensure a selected marker exists

    const updatedName = markerName.value;
    const updatedDescription = markerDescription.value;

    try {
        // Send the updated marker to the backend
        const response = await axios.put(`/markers/${selectedMarker.value.id}`, { 
            name: updatedName, 
            description: updatedDescription 
        });

        // Update the local state with the updated marker data
        const index = markers.value.findIndex(marker => marker.id === selectedMarker.value.id);
        markers.value[index] = response.data;

        // Remove old map marker and add the updated one
        mapMarkers.value.forEach((mapMarker) => {
            if (mapMarker.getLngLat().lat === selectedMarker.value.latitude &&
                mapMarker.getLngLat().lng === selectedMarker.value.longitude) {
                mapMarker.remove();
            }
        });

        // Add the updated marker to the map
        const mapMarker = Radar.ui.marker({
            color: '#FF5733',
            width: 40,
            height: 80,
            popup: { text: response.data.name },
        })
        .setLngLat([response.data.longitude, response.data.latitude])
        .addTo(map);

        // Add the new map marker to the mapMarkers array
        mapMarkers.value.push(mapMarker);

        // Close the dialog after updating the marker
        showEditDialog.value = false;
    } catch (error) {
        console.error('Error updating marker:', error);
    }
};

// Handle marker deletion
const deleteMarker = async () => {
    if (!selectedMarker.value) return;

    try {
        // Delete the marker from the backend
        await axios.delete(`/markers/${selectedMarker.value.id}`);

        // Remove the marker from the local state
        markers.value = markers.value.filter(marker => marker.id !== selectedMarker.value.id);

        // Remove the marker from the map using the stored map reference
        mapMarkers.value.forEach((mapMarker) => {
            if (mapMarker.getLngLat().lat === selectedMarker.value.latitude &&
                mapMarker.getLngLat().lng === selectedMarker.value.longitude) {
                mapMarker.remove();
            }
        });

        // Remove from mapMarkers array
        mapMarkers.value = mapMarkers.value.filter(
            (mapMarker) => mapMarker.getLngLat().lat !== selectedMarker.value.latitude
        );

        // Close the dialog after deleting the marker
        showEditDialog.value = false;
    } catch (error) {
        console.error('Error deleting marker:', error);
    }
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <Card>
                    <CardHeader class="flex h-16 flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">Weather</CardTitle>
                        <img :src="'http://openweathermap.org/img/wn/' + weather.weather[0].icon + '@2x.png'" alt="Weather icon" class="h-12 w-12" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ weather.main.temp }}°C</div>
                        <p class="text-xs text-muted-foreground">{{ weather.wind.speed }} m/s ( {{ weather.weather[0].description }} )</p>
                    </CardContent>
                </Card>
            </div>

            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <div id="map" style="width: 100%; height: 100%" />
            </div>
        </div>

        <!-- Add Marker Dialog -->
        <Dialog :open="showAddDialog" @update:open="showAddDialog = $event">
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Add a new marker</DialogTitle>
                    <DialogDescription>Click on the map to place a new marker.</DialogDescription>
                </DialogHeader>
                <div class="mb-4">
                    <label for="name" class="font-semibold">Name</label>
                    <input v-model="markerName" type="text" class="form-input w-full p-2 mt-2 rounded-md border border-gray-300" placeholder="Marker Name" />
                </div>
                <div class="mb-4">
                    <label for="description" class="font-semibold">Description</label>
                    <textarea v-model="markerDescription" class="form-input w-full p-2 mt-2 rounded-md border border-gray-300" placeholder="Marker Description"></textarea>
                </div>
                <div class="mt-4">
                    <button @click="submitMarker" class="btn btn-primary w-full py-2 rounded-md">Add Marker</button>
                </div>
            </DialogContent>
        </Dialog>

        <!-- Edit Marker Dialog -->
        <Dialog :open="showEditDialog" @update:open="showEditDialog = $event">
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Edit Marker</DialogTitle>
                    <DialogDescription>Edit the details of the selected marker.</DialogDescription>
                </DialogHeader>
                <div class="mb-4">
                    <label for="name" class="font-semibold">Name</label>
                    <input v-model="markerName" type="text" class="form-input w-full p-2 mt-2 rounded-md border border-gray-300" placeholder="Marker Name" />
                </div>
                <div class="mb-4">
                    <label for="description" class="font-semibold">Description</label>
                    <textarea v-model="markerDescription" class="form-input w-full p-2 mt-2 rounded-md border border-gray-300" placeholder="Marker Description"></textarea>
                </div>
                <div class="mt-4 flex gap-2">
                    <button @click="updateMarker" class="btn btn-primary w-full py-2 rounded-md">Update</button>
                    <button @click="deleteMarker" class="btn btn-danger w-full py-2 rounded-md">Delete</button>
                </div>
            </DialogContent>
        </Dialog>
    </AppLayout>
</template>
