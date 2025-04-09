<?php

namespace App\Domains\Deposit\Controllers;

use App\Domains\Deposit\Data\PaymentData;
use App\Domains\Deposit\Data\TransactionData;
use App\Domains\Deposit\Jobs\ProcessDepositJob;
use App\Domains\Deposit\Models\Deposit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * @throws \Throwable
     */
    public function __invoke(PaymentData $payment): bool
    {
        $transactions = collect($payment->txs);

        DB::transaction(function () use ($transactions, $payment, &$walletAddress) {
            $transactions->each(function (TransactionData $transactionData) use ($payment, &$walletAddress) {
                $deposit = Deposit::lockForUpdate()->updateOrCreate(
                    [
                        'transaction_hash' => $transactionData->hash,
                    ],
                    [
                        'confirmed' => $payment->confirmed,
                        'sender' => $transactionData->fromAddress,
                        'amount' => $transactionData->value,
                        'block' => $payment->block->number,
                        'block_timestamp' => $payment->block->timestamp,
                        'block_hash' => $payment->block->hash,
                        'receipt_status' => $transactionData->receiptStatus,
                    ]
                );

                $walletAddress = $transactionData->fromAddress;

                ProcessDepositJob::dispatch(
                    deposit: $deposit,
                );
            });
        });

        return true;
    }
}
