import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import { initializeTheme } from './composables/useAppearance';

import { networks, projectId, solanaWeb3JsAdapter, wagmiAdapter } from '@/config';
import { createAppKit } from '@reown/appkit/vue';
import { QueryClient, VueQueryPlugin } from '@tanstack/vue-query';
import { WagmiPlugin } from '@wagmi/vue';

// import './echo';

const queryClient = new QueryClient();

// Extend ImportMeta interface for Vite...
declare module 'vite/client' {
    interface ImportMetaEnv {
        readonly VITE_APP_NAME: string;

        [key: string]: string | boolean | undefined;
    }

    interface ImportMeta {
        readonly env: ImportMetaEnv;
        readonly glob: <T>(pattern: string) => Record<string, () => Promise<T>>;
    }
}

const appName = import.meta.env.VITE_APP_NAME || 'Real Based Cowboy';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(WagmiPlugin, { config: wagmiAdapter.wagmiConfig })
            .use(VueQueryPlugin, { queryClient })
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

createAppKit({
    adapters: [wagmiAdapter, solanaWeb3JsAdapter],
    networks,
    projectId,
    themeMode: 'light',
    features: {
        email: false,
        socials: [],
        analytics: true,
    },
    metadata: {
        name: 'Based Cowboy',
        description: 'Real Based Cowboy',
        url: 'https://reown.com/appkit',
        icons: ['https://avatars.githubusercontent.com/u/179229932?s=200&v=4'],
    },
    themeVariables: {
        '--w3m-accent': '#000000',
    },
    tokens: {
        '1399811149': {
            // Solana mainnet chain ID
            address: '6p6xgHyF7AeE6TZkSmFsko444wqoP15icUSqi2jfGiPN', // TRUMP mint address
            image: 'https://gettrumpmemes.com/favicon.ico', // Optional: token icon from official site
        },
    },
});

// This will set light / dark mode on page load...
initializeTheme();
