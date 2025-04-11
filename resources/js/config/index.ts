import { SolanaAdapter } from '@reown/appkit-adapter-solana';
import { WagmiAdapter } from '@reown/appkit-adapter-wagmi';
import { base, mainnet, polygon, solana, solanaDevnet, solanaTestnet, type AppKitNetwork } from '@reown/appkit/networks';
import { PhantomWalletAdapter, SolflareWalletAdapter } from '@solana/wallet-adapter-wallets';

export const projectId = process.env.VITE_PROJECT_ID || '31c25b4c47ab9736aa2c3dbed2746400';

if (!projectId) {
    throw new Error('VITE_PROJECT_ID is not set');
}

export const networks: [AppKitNetwork, ...AppKitNetwork[]] = [mainnet, polygon, base, solana, solanaTestnet, solanaDevnet];

export const wagmiAdapter = new WagmiAdapter({
    networks,
    projectId,
});

export const solanaWeb3JsAdapter = new SolanaAdapter({
    wallets: [new PhantomWalletAdapter(), new SolflareWalletAdapter()],
});
