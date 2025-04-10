<script setup lang="ts">
import { Card, CardContent } from '@/components/ui/card';
import { Head, useForm } from '@inertiajs/vue3';
import { useAppKitAccount } from '@reown/appkit/vue';
import { computed, watch } from 'vue';

const accountInfo = useAppKitAccount();

const form = useForm({
    address: '',
    affiliate: '',
});

const getAffiliateCodeFromUrl = () => {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('affiliate') || ''; // Returns 'lol12' or empty string if not present
};

const isFullyConnected = computed(() => {
    return accountInfo.value.isConnected;
});

watch(
    isFullyConnected,
    (newValue, oldValue) => {
        if (newValue && !oldValue && accountInfo.value.address) {
            form.address = accountInfo.value.address;
            form.affiliate = getAffiliateCodeFromUrl();
            form.post(route('register.wallet'));
        }
    },
    { immediate: false },
);
</script>

<template>
    <Head title="Place your bet"></Head>
    <div class="flex min-h-svh flex-col items-center justify-center bg-muted p-6 md:p-10">
        <div class="w-full max-w-sm md:max-w-3xl">
            <div class="flex flex-col gap-6">
                <Card class="overflow-hidden">
                    <CardContent class="grid p-0 md:grid-cols-2">
                        <div class="p-6 md:p-8">
                            <div class="flex flex-col gap-6">
                                <div class="flex flex-col items-center text-center">
                                    <h1 class="text-2xl font-bold">Welcome back, Cowboy</h1>
                                    <p class="text-balance text-muted-foreground">Login to the Real Base Cowboy world</p>
                                    <appkit-button class="mt-4"></appkit-button>
                                </div>
                            </div>
                        </div>
                        <div class="relative hidden bg-muted md:block">
                            <img
                                src="/img/cowboy.jpeg"
                                alt="Image"
                                class="absolute inset-0 h-full w-full object-cover dark:brightness-[0.2] dark:grayscale"
                            />
                        </div>
                    </CardContent>
                </Card>
                <div class="text-balance text-center text-xs text-muted-foreground [&_a]:underline [&_a]:underline-offset-4 hover:[&_a]:text-primary">
                    By clicking continue, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
                </div>
            </div>
        </div>
    </div>
</template>
