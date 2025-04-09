<script lang="ts" setup>
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem, SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { BitcoinIcon, Copy, Rocket, Search } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import { toast } from 'vue-sonner';

const page = usePage<SharedData>();
const currencies = page.props.currencies;

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Deposit', href: '/deposit' },
];

interface Currency {
    id: string;
    name: string;
    ticker?: string;
    deposit_address: string;
    contract_address: string;
    chain_id?: string;
}

const searchTerm = ref('');

const filteredCurrencies = computed(() => {
    const term = searchTerm.value.toLowerCase();
    return (currencies as Currency[]).filter(
        (currency) =>
            currency.name.toLowerCase().includes(term) ||
            currency.ticker?.toLowerCase().includes(term) ||
            currency.chain_id?.toLowerCase().includes(term),
    );
});

const copyToClipboard = async (currency: Currency) => {
    await window.navigator.clipboard.writeText(currency.deposit_address);
    toast.success(`Copied ${currency.deposit_address}`);
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Deposit Funds" />

        <div class="container mx-auto px-4 py-6 sm:max-w-3xl">
            <div class="space-y-4">
                <Alert variant="default">
                    <Rocket class="h-4 w-4" />
                    <AlertTitle>Is your token not listed but available on a decentralized exchange?</AlertTitle>
                    <AlertDescription
                        >Just request it
                        <Link class="underline" :href="route('currency.index')">here</Link>
                    </AlertDescription>
                </Alert>

                <div class="flex flex-col justify-between gap-2 sm:flex-row sm:items-center">
                    <h1 class="text-xl font-semibold">Deposit Cryptocurrency</h1>
                    <span class="text-xs text-muted-foreground"> {{ filteredCurrencies.length }} of {{ currencies.length }} currencies </span>
                </div>

                <!-- Search -->
                <div class="relative w-full sm:w-64">
                    <Search class="absolute left-2 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
                    <Input v-model="searchTerm" placeholder="Search currencies..." class="h-9 w-full border-gray-200 pl-8 text-sm" />
                </div>

                <!-- Currency Grid -->
                <div class="grid grid-cols-1 items-stretch gap-3 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
                    <Card
                        v-for="currency in filteredCurrencies"
                        :key="currency.id"
                        class="flex h-full flex-col justify-between rounded-lg border p-3 shadow-none"
                    >
                        <div>
                            <div class="mb-3 flex items-center gap-3">
                                <BitcoinIcon class="h-6 w-6 shrink-0 sm:h-5 sm:w-5" />
                                <div class="flex-1 text-left">
                                    <span class="block text-sm font-medium sm:text-base">
                                        {{ currency.name }}
                                    </span>
                                    <span class="block text-xs text-muted-foreground"> ${{ currency.ticker }} </span>
                                </div>
                            </div>
                        </div>

                        <Button
                            :disabled="!currency.deposit_address"
                            class="mt-3 flex w-full items-center gap-2 text-xs sm:text-sm"
                            variant="outline"
                            @click="copyToClipboard(currency)"
                        >
                            <Copy class="h-3 w-3 shrink-0" />
                            <span class="min-w-0 flex-1 truncate">{{ currency.deposit_address }}</span>
                        </Button>
                    </Card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
