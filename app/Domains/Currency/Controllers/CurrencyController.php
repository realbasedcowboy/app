<?php

namespace App\Domains\Currency\Controllers;

use App\Domains\Currency\Models\Currency;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CurrencyController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('currency/Index');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'ticker' => ['required', 'string', 'max:10'],
            'cmc_url' => ['required', 'url'],
            'contract_address' => ['required', 'string', 'min:10', 'unique:currencies,contract_address'],
        ]);

        $currency = Currency::create(
            [
                ...$request->all(),
                'chain_id' => 1,
                'deposit_address' => '',
                'price' => 0,
            ]
        );

        $request->user()->currencies()->save($currency);

        return redirect()
            ->route('currency.index')
            ->with('success', 'Your token request has been submitted.');
    }
}
