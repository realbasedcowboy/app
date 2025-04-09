<?php

namespace App\Http\Controllers\Settings;

use App\Domains\Deposit\Models\Deposit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DepositsController extends Controller
{
    /**
     * Show the user's deposits history page.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('settings/Deposits', [
            'deposits' => Deposit::where('sender', auth()->user()->address)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
                ->map(fn (Deposit $deposit) => [
                    'id' => $deposit->id,
                    'transaction_hash' => $deposit->transaction_hash,
                    'amount' => $deposit->amount,
                    'token_ticker' => $deposit->token_ticker,
                    'block_timestamp' => $deposit->block_timestamp,
                    'confirmed' => $deposit->confirmed,
                    'receipt_status' => $deposit->receipt_status,
                ]),
        ]);
    }
}
