<script setup lang="ts">
import { Toaster } from '@/components/ui/sonner';
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import { useAppKitAccount } from '@reown/appkit/vue';
import { onMounted, onUnmounted } from 'vue';
import { toast } from 'vue-sonner';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

const accountInfo = useAppKitAccount();
let channel: any; // Add variable to store the channel reference

onMounted(() => {
    channel = window.Echo.private(`user.${accountInfo.value.address}`).listen('.event', (e) => {
        console.log(e);
        toast(e.message);
    });
});

onUnmounted(() => {
    if (channel) {
        channel.stopListening('.event'); // Remove the specific event listener
        window.Echo.leave(`user.${accountInfo.value.address}`); // Leave the channel entirely
    }
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <slot />
        <Toaster />
    </AppLayout>
</template>
