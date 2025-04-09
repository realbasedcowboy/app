<script lang="ts" setup>
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuGroup, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { SidebarMenuButton } from '@/components/ui/sidebar';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { ChevronsUpDown } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const page = usePage();
const balances = computed(() => page.props.auth?.balances || []);
const activeBalance = ref(page.props.auth?.active_balance);

const form = useForm({
    balance: null,
});

const updateSelectedBalance = (balance) => {
    form.balance = balance;

    form.post(route('update-active-balance'), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            activeBalance.value.currency = balance;
        },
        onError: () => {},
        onFinish: () => {
            form.reset();
        },
    });
};

const formatBalance = (balance) => {
    if (!balance) return { integer: '0', decimal: '00' };
    const fixed = Number(balance).toFixed(2);
    const [integer, decimal] = fixed.split('.');
    return { integer, decimal };
};
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <SidebarMenuButton size="md" class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground">
                <span>
                    {{ activeBalance.currency.ticker }}
                    <span class="balance-display">
                        <span class="integer-part">
                            {{ formatBalance(balances.find((b) => b.ticker === activeBalance.currency.ticker)?.balance).integer }}
                        </span>
                        <span class="decimal-part">
                            .{{ formatBalance(balances.find((b) => b.ticker === activeBalance.currency.ticker)?.balance).decimal }}
                        </span>
                    </span>
                </span>
                <ChevronsUpDown class="ml-auto size-4" />
            </SidebarMenuButton>
        </DropdownMenuTrigger>

        <DropdownMenuContent class="w-[--radix-dropdown-menu-trigger-width] min-w-56 rounded-lg" side="bottom" align="end" :side-offset="4">
            <DropdownMenuGroup>
                <DropdownMenuItem
                    v-for="balance in balances"
                    :key="balance.id"
                    class="flex items-center justify-between"
                    @click="updateSelectedBalance(balance)"
                >
                    {{ balance.ticker }}
                    <span class="balance-display justify items-center">
                        <span class="integer-part">{{ formatBalance(balance.balance).integer }}</span>
                        <span class="decimal-part">.{{ formatBalance(balance.balance).decimal }}</span>
                    </span>
                </DropdownMenuItem>
                <div class="p-2">
                    <Button as-child class="w-full">
                        <Link :href="route('currency.index')">Request new $token</Link>
                    </Button>
                </div>
            </DropdownMenuGroup>
        </DropdownMenuContent>
    </DropdownMenu>
</template>

<style scoped>
.decimal-part {
    font-size: 0.7em;
    position: relative;
    top: -3px;
}
</style>
