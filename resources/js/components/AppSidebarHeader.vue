<script setup lang="ts">
import BalanceSelector from '@/components/BalanceSelector.vue';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import DepositButton from '@/components/DepositButton.vue';
import { SidebarTrigger } from '@/components/ui/sidebar';
import type { BreadcrumbItemType } from '@/types';

defineProps<{
    breadcrumbs?: BreadcrumbItemType[];
}>();
</script>

<template>
    <header
        class="flex h-16 shrink-0 items-center gap-2 border-b border-sidebar-border/70 px-6 transition-[width,height] ease-linear group-has-[[data-collapsible=icon]]/sidebar-wrapper:h-12 md:px-4"
    >
        <div class="flex items-center gap-2">
            <SidebarTrigger class="-ml-1" />
            <template v-if="breadcrumbs.length > 0">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </template>
        </div>

        <div class="flex-grow"></div>

        <div class="flex items-center gap-3">
            <DepositButton />
            <BalanceSelector />
        </div>
    </header>
</template>
