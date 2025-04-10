<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { asset } from '@/lib/utils'

defineProps<{
    memes: {
        id: number;
        title: string;
        description: string | null;
        image: string;
    }[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
</script>

<template>
    <Head title="My Memes" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-6 p-4 max-w-7xl mx-auto">
            <h1 class="text-3xl font-bold">My Memes</h1>

            <div
                class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 auto-rows-fr"
            >
                <Card
                    v-for="meme in memes"
                    :key="meme.id"
                    class="flex flex-col overflow-hidden"
                >
                    <img
                        :src="asset(meme.image)"
                        :alt="meme.title"
                        class="object-cover aspect-square w-full"
                    />
                    <CardHeader>
                        <CardTitle class="truncate">{{ meme.title }}</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p class="text-sm text-muted-foreground line-clamp-3">
                            {{ meme.description || 'No description' }}
                        </p>
                    </CardContent>
                </Card>

                <p v-if="!memes.length" class="col-span-full text-muted-foreground text-center">
                    You haven't uploaded any memes yet.
                </p>
            </div>
        </div>
    </AppLayout>
</template>
