<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import { Badge } from '@/components/ui/badge';
import { Table, TableBody, TableCell, TableEmpty, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import { onMounted, onUnmounted, ref } from 'vue';

const page = usePage<SharedData>();
const deposits = ref(page.props.deposits);
const userAddress = page.props.auth.user.address;

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Deposits history',
        href: '/settings/deposits',
    },
];

interface Deposit {
    id: string;
    transaction_hash: string;
    amount: string;
    token_ticker: string;
    block_timestamp: string;
    confirmed: boolean;
    receipt_status: boolean;
}

const formatDate = (timestamp: string) => {
    return new Date(timestamp).toLocaleString();
};

const truncateHash = (hash: string) => {
    return `${hash.slice(0, 4)}...${hash.slice(-4)}`;
};

const getStatusText = (deposit: Deposit) => {
    if (!deposit.confirmed) return 'Pending';
    return deposit.receipt_status ? 'Completed' : 'Failed';
};

// Websocket event handling
onMounted(() => {
    window.Echo.private(`user.${userAddress}`).listen('.event', (e) => {
        deposits.value = [e.deposit, ...deposits.value];
    });
});

onUnmounted(() => {
    window.Echo.private(`user.${userAddress}`).stopListening('.event');
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Deposits history" />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Deposits history" description="View your deposit history" />

                <div class="text-md rounded-md border text-sm">
                    <Table class="w-full">
                        <TableHeader>
                            <TableRow>
                                <TableHead>Date</TableHead>
                                <TableHead>Transaction</TableHead>
                                <TableHead>Amount</TableHead>
                                <!--                                <TableHead>Token</TableHead>-->
                                <TableHead>Status</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableEmpty v-if="deposits.length === 0" colspan="5"> No deposits found</TableEmpty>
                            <TableRow v-for="deposit in deposits" :key="deposit.id">
                                <TableCell class="">{{ formatDate(deposit.block_timestamp) }}</TableCell>
                                <TableCell>
                                    <a
                                        :href="`https://etherscan.io/tx/${deposit.transaction_hash}`"
                                        target="_blank"
                                        class="text-primary hover:underline"
                                    >
                                        {{ truncateHash(deposit.transaction_hash) }}
                                    </a>
                                </TableCell>
                                <TableCell>{{ Number(deposit.amount) }}</TableCell>
                                <!--                                <TableCell>{{ deposit.token_ticker }}</TableCell>-->
                                <TableCell>
                                    <Badge class="bg-green-500 hover:bg-green-600">
                                        {{ getStatusText(deposit) }}
                                    </Badge>
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
