<script lang="ts" setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Card, CardContent } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import type { BreadcrumbItem } from '@/types';
import { toast } from 'vue-sonner';
import { TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';

const page = usePage();


const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Airdrops', href: '/airdrops' },
];

const airdrop = page.props.airdrop;
const hasAirdrop = !!airdrop?.id;

const hasParticipants = airdrop?.participants?.length > 0;

const form = useForm({
    title: airdrop?.name ?? '',
    keyword: airdrop?.keyword ?? '',
});

function submit() {
    form.post(route('airdrops.edit'), {
        onSuccess: () => {
            toast.success('Your airdrop has been saved');
        }
    });
}
</script>

<template>
    <Head title="Airdrops" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-6 p-4 max-w-2xl mx-auto">
            <h1 class="text-3xl font-bold">Create Telegram Airdrop Event</h1>
            <p class="text-muted-foreground text-sm">
                When you start an airdrop event, users have a short period of time to respond in the chat with a specific keyword. After the time is up, the airdrop closes and the winners are saved.
                Example: type <code>!airdropme123</code> in the chat.
            </p>

            <!-- Form Card -->
            <Card>
                <CardContent class="p-6 space-y-4">
                    <form @submit.prevent="submit" class="space-y-4">
                        <!-- Title -->
                        <div>
                            <Label for="title">Title</Label>
                            <Input
                                id="title"
                                v-model="form.title"
                                placeholder="Title of airdrop event"
                                :disabled="hasAirdrop"
                            />
                            <p v-if="form.errors.title" class="text-red-500 text-sm mt-1">
                                {{ form.errors.title }}
                            </p>
                        </div>

                        <!-- Keyword -->
                        <div>
                            <Label for="keyword">Keyword</Label>
                            <Input
                                id="keyword"
                                v-model="form.keyword"
                                placeholder="Word users need to type in chat"
                                :disabled="hasAirdrop"
                            />
                            <p v-if="form.errors.keyword" class="text-red-500 text-sm mt-1">
                                {{ form.errors.keyword }}
                            </p>
                        </div>

                        <!-- Submit -->
                        <div class="pt-4">
                            <Button type="submit" class="w-full" :disabled="form.processing || hasAirdrop">
                                {{ form.processing ? 'Saving airdrop...' : 'Save airdrop' }}
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>

            <!-- Participants Table -->
            <div v-if="hasAirdrop" class="mt-8">
                <h2 class="text-2xl font-semibold mb-4">Participants</h2>
                <div class="rounded-md border text-sm">
                    <Table v-if="hasAirdrop" class="w-full">
                        <TableHeader>
                            <TableRow>
                                <TableHead class="w-[50px]">#</TableHead>
                                <TableHead>Username</TableHead>
                                <TableHead>Joined At</TableHead>
                            </TableRow>
                        </TableHeader>

                        <TableBody>
                            <TableRow
                                v-for="(participant, index) in participants"
                                :key="participant.id"
                                class="hover:bg-muted/50"
                            >
                                <TableCell>{{ index + 1 }}</TableCell>
                                <TableCell>{{ participant.username }}</TableCell>
                                <TableCell>{{ participant.joined_at }}</TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
