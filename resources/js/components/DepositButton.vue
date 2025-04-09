<script lang="ts" setup>
import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/vue3';
import { Wallet } from 'lucide-vue-next';
</script>
<template>
    <Button class="px-3">
        <Link :href="route('deposit.index')">
            <Wallet />
        </Link>
    </Button>
</template>
