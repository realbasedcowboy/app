<?php

namespace App\Http\Controllers\Deposit;

use App\Domains\Currency\Models\Currency;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class DepositController extends Controller
{
    public function index()
    {
        return Inertia::render('deposit/Index', [
            'currencies' => Currency::all(),
        ]);
    }
}
