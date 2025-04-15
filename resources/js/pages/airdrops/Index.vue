<script lang="ts" setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Button } from '@/components/ui/button';


const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Airdrops', href: '/airdrops' },
];

const page = usePage()
const airdrops = page.props.airdrops
</script>
<template>
    <Head title="Airdrops" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="md:w-1/2 md:mx-auto">
            <div class="flex p-4 justify-between" v-if="airdrops?.length">
                <h1 class="text-3xl font-bold">Create airdrop</h1>
                <Link :href="route('airdrops.edit')">
                    <Button>Create airdrop</Button>
                </Link>
            </div>

            <div class="rounded-md border text-sm" v-if="airdrops?.length">
                <Table class="w-full">
                    <TableHeader>
                        <TableRow>
                            <TableHead>#</TableHead>
                            <TableHead>Name</TableHead>
                            <TableHead>Participants</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="(airdrop, index) in airdrops" :key="airdrop.id" @click="() => $inertia.visit(route('airdrops.edit', { id: airdrop.id }))" class="cursor-pointer">
                            <TableCell>{{ index + 1 }}</TableCell>
                            <TableCell>{{ airdrop.name }}</TableCell>
                            <TableCell>{{ airdrop.participants || 0}}</TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
            <div v-else class="text-center pt-5">
                <Link :href="route('airdrops.edit')">
                    <Button>Create your first airdrop</Button>
                </Link>
            </div>
        </div>
    </AppLayout>
</template>
