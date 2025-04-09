<script setup lang="ts">
import RequestTokenForm from '@/components/forms/RequestTokenForm.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

// const page = usePage<SharedData>();

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Currencies', href: '/currency' },
];
</script>
<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Coin Flip" />
        <div class="container mx-auto max-w-lg px-4 py-8">
            <RequestTokenForm />
        </div>
    </AppLayout>
</template>
