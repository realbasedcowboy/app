<script lang="ts" setup>
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useForm } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';

const form = useForm({
    name: '',
    ticker: '',
    cmc_url: '',
    contract_address: '',
});

const submit = () => {
    form.post(route('currency.store'), {
        onSuccess: () => {
            form.reset();

            toast.success('Request success');
        },
    });
};
</script>

<template>
    <Card class="mx-auto max-w-md">
        <CardHeader>
            <CardTitle>Request new token</CardTitle>
        </CardHeader>

        <CardContent class="space-y-4">
            <div>
                <Label for="token_name">Token Name</Label>
                <Input
                    id="token_name"
                    type="text"
                    v-model="form.name"
                    @input="form.clearErrors('name')"
                    :class="{ 'border-red-500': form.errors.name }"
                    placeholder="Example Token"
                />
                <p v-if="form.errors.name" class="mt-1 text-sm text-red-500">
                    {{ form.errors.name }}
                </p>
            </div>

            <div>
                <Label for="token_ticker">Token Ticker</Label>
                <Input
                    id="token_ticker"
                    type="text"
                    v-model="form.ticker"
                    @input="form.clearErrors('ticker')"
                    :class="{ 'border-red-500': form.errors.ticker }"
                    placeholder="EXM"
                />
                <p v-if="form.errors.ticker" class="mt-1 text-sm text-red-500">
                    {{ form.errors.ticker }}
                </p>
            </div>

            <div>
                <Label for="cmc_url">CoinMarketCap URL</Label>
                <Input
                    id="cmc_url"
                    type="url"
                    v-model="form.cmc_url"
                    @input="form.clearErrors('cmc_url')"
                    :class="{ 'border-red-500': form.errors.cmc_url }"
                    placeholder="https://coinmarketcap.com/currencies/example-token"
                />
                <p v-if="form.errors.cmc_url" class="mt-1 text-sm text-red-500">
                    {{ form.errors.cmc_url }}
                </p>
            </div>

            <div>
                <Label for="contract_address">Contract Address</Label>
                <Input
                    id="contract_address"
                    type="text"
                    v-model="form.contract_address"
                    @input="form.clearErrors('contract_address')"
                    :class="{ 'border-red-500': form.errors.contract_address }"
                    placeholder="0x..."
                />
                <p v-if="form.errors.contract_address" class="mt-1 text-sm text-red-500">
                    {{ form.errors.contract_address }}
                </p>
            </div>

            <Button :disabled="form.processing" @click="submit" class="w-full"> Submit</Button>
        </CardContent>
    </Card>
</template>
