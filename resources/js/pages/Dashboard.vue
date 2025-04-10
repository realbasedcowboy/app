<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Card, CardContent, CardHeader, CardFooter } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { ThumbsUp, ThumbsDown } from 'lucide-vue-next';
import { ref } from 'vue';

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
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

// Track user votes for each meme
const userVotes = ref<Record<number, 'like' | 'dislike' | null>>({});

const handleLike = (memeId: number) => {
    userVotes.value[memeId] = userVotes.value[memeId] === 'like' ? null : 'like';
};

const handleDislike = (memeId: number) => {
    userVotes.value[memeId] = userVotes.value[memeId] === 'dislike' ? null : 'dislike';
};

// Simple time ago formatter (you might want to use a library like date-fns)
const formatTimeAgo = (date: string) => {
    const now = new Date();
    const created = new Date(date);
    const diffInHours = Math.floor((now.getTime() - created.getTime()) / (1000 * 60 * 60));

    if (diffInHours < 1) return 'Less than an hour ago';
    if (diffInHours < 24) return `${diffInHours} hour${diffInHours === 1 ? '' : 's'} ago`;
    return `${Math.floor(diffInHours / 24)} day${Math.floor(diffInHours / 24) === 1 ? '' : 's'} ago`;
};
</script>

<template>
    <Head title="My Memes" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-6 p-4 mx-auto">
            <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 auto-rows-fr">
                <Card
                    v-for="meme in memes"
                    :key="meme.id"
                    class="max-w-md overflow-hidden"
                >
                    <CardContent class="p-0">
                        <div class="relative aspect-video w-full overflow-hidden">
                            <img
                                :src="meme.media[0]?.preview_url || '/placeholder.svg'"
                                :alt="meme.title"
                                class="object-cover w-full h-full"
                                loading="eager"
                            >
                        </div>
                        <div class="pt-3 p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="text-xl font-bold">{{ meme.title }}</h2>
                                    <p class="text-xs text-muted-foreground">
                                        {{ formatTimeAgo(meme.created_at) }}
                                    </p>
                                </div>
                                <Badge variant="outline" class="ml-2">
                                    Meme
                                </Badge>
                            </div>
                            <p class="mt-2">
                                {{ meme.description || 'No description' }}
                            </p>
                        </div>
                    </CardContent>

                    <CardFooter class="flex justify-between border-t p-2">
                        <div class="flex">
                            <Button
                                variant="ghost"
                                size="sm"
                                :class="['flex items-center gap-1', { 'text-green-600': userVotes[meme.id] === 'like' }]"
                                @click="handleLike(meme.id)"
                            >
                                <ThumbsUp class="h-4 w-4" />
                                <span>{{ meme.likes || 0 }}</span>
                            </Button>
                            <Button
                                variant="ghost"
                                size="sm"
                                :class="['flex items-center gap-1', { 'text-red-600': userVotes[meme.id] === 'dislike' }]"
                                @click="handleDislike(meme.id)"
                            >
                                <ThumbsDown class="h-4 w-4" />
                                <span>{{ meme.dislikes || 0 }}</span>
                            </Button>
                        </div>
                    </CardFooter>
                </Card>

                <p v-if="!memes.length" class="col-span-full text-muted-foreground text-center">
                    You haven't uploaded any memes yet.
                </p>
            </div>
        </div>
    </AppLayout>
</template>
