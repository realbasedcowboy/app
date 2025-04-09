import { clusterApiUrl, Connection, PublicKey } from '@solana/web3.js';
import axios from 'axios';

// Setup
const connection = new Connection(clusterApiUrl('devnet'), 'confirmed');
const bankAddress = new PublicKey('AzXG8HjkGdSk6a3P6XN6izSxB65B8Z1XA2iKWUVNpHeS');

// Keep track of already processed signatures
const processed = new Set();

async function checkForNewDeposits() {
    //try {
    const signatures = await connection.getSignaturesForAddress(bankAddress, { limit: 10 });

    for (const sigInfo of signatures) {
        if (processed.has(sigInfo.signature)) continue;

        const tx = await connection.getTransaction(sigInfo.signature, { commitment: 'confirmed' });
        if (!tx) continue;

        const amount = tx?.meta?.postBalances?.[0] - tx?.meta?.preBalances?.[0];
        const sender = tx.transaction.message.accountKeys[0].toBase58();

        // Add to processed set
        processed.add(sigInfo.signature);

        // Notify Laravel API
        try {
            await axios.post('https://hopium-api.ddev.site/api/deposit', {
                signature: sigInfo.signature,
                amount,
                sender,
            });
        } catch (e) {
            console.error('something went wrong', e.message);
        }

        console.log(`✔️ New deposit: ${amount} lamports from ${sender}`);
    }
}

// Poll every 10 seconds
setInterval(checkForNewDeposits, 10000);
