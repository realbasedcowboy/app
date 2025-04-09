<script setup lang="ts">
import CoinFlipComponent from '@/components/games/CoinFlipGame.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import AppLayout from '@/layouts/AppLayout.vue';
import { SharedData } from '@/types';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, onMounted, ref } from 'vue';

const page = usePage<SharedData>();
const activeBalance = page.props.auth.user.active_balance;

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Coin Flip', href: '/coin-flip' },
];

const choice = ref<string>('heads');
const betAmount = ref<number>(0);
const coinResult = ref<string | null>(null); // Add state for coin result
const flipKey = ref(0); // Add key to force component re-render

const isButtonDisabled = computed(() => !betAmount.value || betAmount.value <= 0 || betAmount.value > activeBalance.balance);

const setQuickBet = (amount: number) => {
    betAmount.value = Math.min(amount, activeBalance.balance);
};

const quickBets = [100, 1000, 10000];

const form = useForm({
    amount: 1,
    choice: 'heads',
    clientSeed: null,
});

const isFlipping = ref(false);

const submit = () => {
    form.amount = betAmount.value;
    form.choice = choice.value;
    form.clientSeed = clientSeed.value;

    form.post(route('coinflip.bet'), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            const result = page.props.flash.placedBet?.final_result;

            if (result) {
                coinResult.value = result;
                flipKey.value += 1;
            }

            isFlipping.value = true;

            form.reset();
        },
    });
};

const clientSeed = ref<string>('');

function generateRandomSeed() {
    const array = new Uint8Array(32);
    window.crypto.getRandomValues(array);
    return Array.from(array)
        .map((byte) => byte.toString(16).padStart(2, '0'))
        .join('');
}

function generateNewRandomSeed() {
    clientSeed.value = generateRandomSeed();
}

onMounted(() => {
    clientSeed.value = generateRandomSeed();
});

const isFlipEnded = function () {
    isFlipping.value = false;
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Coin Flip" />

        <CoinFlipComponent @flip-ended="isFlipEnded" :choice="form.choice" v-if="coinResult" :key="flipKey" :result="coinResult" />

        <div class="container mx-auto max-w-lg px-4 py-8" v-if="!isFlipping">
            <Card>
                <CardHeader>
                    <div class="flex items-center justify-between">
                        <CardTitle>Coin Flip</CardTitle>
                    </div>
                    <CardDescription>Test your luck with a fair 50/50 chance to double your bet!</CardDescription>
                </CardHeader>

                <CardContent class="space-y-6">
                    <!-- Bet Amount Section -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <Label for="bet-amount">Bet Amount</Label>
                            <span class="text-sm">
                                Max:
                                {{
                                    page.props.auth.user.balances.filter((balance) => balance.id === page.props.auth.user.active_balance_id)[0]
                                        .balance
                                }}

                                <strong>${{ page.props.auth.user.active_balance.currency.ticker }}</strong>
                            </span>
                        </div>
                        <Input
                            id="bet-amount"
                            type="number"
                            v-model="betAmount"
                            :min="0"
                            :max="activeBalance.balance"
                            step="0.01"
                            placeholder="0.00"
                            :disabled="page.props.auth.user.active_balance.balance == 0"
                        />
                        <div class="grid grid-cols-5 gap-2">
                            <Button
                                v-for="amount in quickBets"
                                :key="amount"
                                variant="outline"
                                :class="{ 'border-blue-500 bg-blue-100': betAmount === amount }"
                                @click="setQuickBet(amount)"
                                :disabled="amount > page.props.auth.user.active_balance.balance"
                            >
                                {{ amount }}
                            </Button>
                        </div>
                    </div>

                    <!-- Choice Selection -->
                    <div class="space-y-2">
                        <Label>Pick Your Side</Label>
                        <RadioGroup v-model="choice" class="grid grid-cols-2 gap-4">
                            <div>
                                <RadioGroupItem value="heads" id="heads" class="sr-only" />
                                <Label
                                    for="heads"
                                    class="flex cursor-pointer items-center justify-center rounded border p-4"
                                    :class="{
                                        'border-blue-500 bg-blue-50': choice === 'heads',
                                        'border-gray-200': choice !== 'heads',
                                    }"
                                >
                                    <svg class="mr-2 h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10" />
                                    </svg>
                                    Heads
                                </Label>
                            </div>
                            <div>
                                <RadioGroupItem value="tails" id="tails" class="sr-only" />
                                <Label
                                    for="tails"
                                    class="flex cursor-pointer items-center justify-center rounded border p-4"
                                    :class="{
                                        'border-blue-500 bg-blue-50': choice === 'tails',
                                        'border-gray-200': choice !== 'tails',
                                    }"
                                >
                                    <svg class="mr-2 h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" />
                                    </svg>
                                    Tails
                                </Label>
                            </div>
                        </RadioGroup>
                    </div>

                    <div class="text-center">
                        <Input v-model="clientSeed" type="text" placeholder="Enter your seed or use generated one" />
                        <Button variant="link" @click="generateNewRandomSeed">Generate Random Seed</Button>
                    </div>

                    <Button class="w-full" @click="submit" :disabled="isButtonDisabled">Place Bet & Flip Coin</Button>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
