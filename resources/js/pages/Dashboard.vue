<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import MemeCard from '@/components/MemeCard.vue';
import { type BreadcrumbItem } from '@/types';

defineProps<{
    memes: {
        id: number;
        title: string;
        description: string | null;
        media: {
            original_url: string;
            preview_url?: string;
        }[];
        created_at: string;
        likes?: number;
        dislikes?: number;
    }[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' }
];
</script>

<template>
    <Head title="My Memes" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-6 p-4 mx-auto">
            <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 auto-rows-fr">
                <MemeCard v-for="meme in memes" :key="meme.id" :meme="meme" />
            </div>
        </div>
    </AppLayout>
</template>
