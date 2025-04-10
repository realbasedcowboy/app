<!-- components/MemeCard.vue -->
<script lang="ts" setup>
import { ref } from 'vue';
import { ThumbsDown, ThumbsUp } from 'lucide-vue-next';
import { Card, CardContent, CardFooter } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';

defineProps<{
    meme: {
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
    };
}>();

const userVotes = ref<'like' | 'dislike' | null>(null);

const handleLike = () => {
    userVotes.value = userVotes.value === 'like' ? null : 'like';
};

const handleDislike = () => {
    userVotes.value = userVotes.value === 'dislike' ? null : 'dislike';
};

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
    <Card class="max-w-md overflow-hidden">
        <CardContent class="p-0">
            <div class="relative aspect-video w-full overflow-hidden">
                <img
                    :src="meme.media[0]?.preview_url || '/placeholder.svg'"
                    :alt="meme.title"
                    class="h-full w-full object-cover"
                    loading="eager"
                />
            </div>
            <div class="p-4 pt-3">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-xl font-bold">{{ meme.title }}</h2>
                        <p class="text-xs text-muted-foreground">{{ formatTimeAgo(meme.created_at) }}</p>
                    </div>
                    <Badge variant="outline" class="ml-2">Meme</Badge>
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
                    :class="['flex items-center gap-1', { 'text-green-600': userVotes === 'like' }]"
                    @click="handleLike"
                >
                    <ThumbsUp class="h-4 w-4" />
                    <span>{{ meme.likes || 0 }}</span>
                </Button>
                <Button
                    variant="ghost"
                    size="sm"
                    :class="['flex items-center gap-1', { 'text-red-600': userVotes === 'dislike' }]"
                    @click="handleDislike"
                >
                    <ThumbsDown class="h-4 w-4" />
                    <span>{{ meme.dislikes || 0 }}</span>
                </Button>
            </div>
        </CardFooter>
    </Card>
</template>
