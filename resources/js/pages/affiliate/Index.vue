<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { type SharedData, type User } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';

import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Rocket } from 'lucide-vue-next';

const page = usePage<SharedData>();
const user = page.props.auth.user as User;

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Affiliate',
        href: '/affiliate',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Affiliate" />
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="container mx-auto max-w-screen-md">
                <Alert>
                    <Rocket class="h-4 w-4" />
                    <AlertTitle>Your affiliate url!</AlertTitle>
                    <AlertDescription>
                        Want to earn extra income?
                        <span class="underline">https://hopium-api.ddev.site?affiliate={{ user.affiliate_code }}</span>
                    </AlertDescription>
                </Alert>
                <div class="mt-4 rounded-md border text-sm" v-if="page.props.invitees.length > 0">
                    <Table class="w-full">
                        <TableHeader>
                            <TableRow>
                                <TableHead>Address</TableHead>
                                <TableHead>Bets</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <template v-for="invitee in page.props.invitees" :key="invitee.id">
                                <!-- User Row -->
                                <TableRow class="bg-gray-50">
                                    <TableCell>{{ invitee.address }}</TableCell>
                                    <TableCell>{{ invitee.bets }}</TableCell>
                                    <!-- Empty cell for alignment -->
                                </TableRow>
                                <!-- Wagered Row -->
                                <template v-for="wagered in invitee.wagered" :key="wagered.currency">
                                    <TableRow v-if="wagered.wagered > 0">
                                        <TableCell class="pl-8 italic text-gray-600">↳ {{ wagered.currency }} </TableCell>
                                        <!-- Empty cell for alignment -->
                                        <TableCell>{{ wagered.wagered }}</TableCell>
                                    </TableRow>
                                </template>
                            </template>
                        </TableBody>
                    </Table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
