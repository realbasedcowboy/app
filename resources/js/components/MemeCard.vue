<script lang="ts" setup>
import { ref } from 'vue';
import { ThumbsDown, ThumbsUp } from 'lucide-vue-next';
import { Card, CardContent, CardFooter } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';

const props = defineProps<{
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

const VoteType = {
    LIKE: 'like',
    DISLIKE: 'dislike'
}

const userVotes = ref<VoteType | null>(null)

// Create a local state for likes and dislikes
const localMeme = ref({
    ...props.meme,
    likes: props.meme.likes || 0,
    dislikes: props.meme.dislikes || 0,
});

const handleVote = async (voteType: 'like' | 'dislike') => {
    // Avoid multiple votes
    if (userVotes.value === voteType) return;

    userVotes.value = voteType === 'like' ? VoteType.LIKE : VoteType.DISLIKE;

    // Fetch the CSRF token from the page
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    const response = await fetch(`/meme/${props.meme.id}/vote?vote=${voteType}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken, // Include CSRF token
        },
    });

    if (response.ok) {
        // Update the local meme's likes/dislikes based on the response
        const updatedMeme = await response.json();
        localMeme.value.likes = updatedMeme.likes;
        localMeme.value.dislikes = updatedMeme.dislikes;
    }
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
                    :src="localMeme.media[0]?.preview_url || '/placeholder.svg'"
                    :alt="localMeme.title"
                    class="h-full w-full object-cover"
                    loading="eager"
                />
            </div>
            <div class="p-4 pt-3">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-xl font-bold">{{ localMeme.title }}</h2>
                        <p class="text-xs text-muted-foreground">{{ formatTimeAgo(localMeme.created_at) }}</p>
                    </div>
                    <Badge variant="outline" class="ml-2">Meme</Badge>
                </div>
                <p class="mt-2">
                    {{ localMeme.description || 'No description' }}
                </p>
            </div>
        </CardContent>

        <CardFooter class="flex justify-between border-t p-2">
            <div class="flex">
                <Button
                    variant="ghost"
                    size="sm"
                    :class="['flex items-center gap-1', { 'text-green-600': userVotes?.value === 'like' }]"
                    @click="handleVote('like')"
                    :disabled="userVotes?.value === 'like'"
                >
                <ThumbsUp class="h-4 w-4" />
                <span>{{ localMeme.likes || 0 }}</span>
                </Button>
                <Button
                    variant="ghost"
                    size="sm"
                    :class="['flex items-center gap-1', { 'text-red-600': userVotes?.value === 'dislike' }]"
                    @click="handleVote('dislike')"
                    :disabled="userVotes?.value === 'dislike'"
                >
                <ThumbsDown class="h-4 w-4" />
                <span>{{ localMeme.dislikes || 0 }}</span>
                </Button>
            </div>
        </CardFooter>
    </Card>
</template>
