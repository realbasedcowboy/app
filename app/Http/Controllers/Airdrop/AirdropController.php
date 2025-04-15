<?php

namespace App\Http\Controllers\Airdrop;

use App\Domains\Airdrop\Models\Airdrop;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AirdropController extends Controller
{
    public function index()
    {
        return Inertia::render('airdrops/Index', [
            'airdrops' => Airdrop::all(),
        ]);
    }

    public function edit(Airdrop $airdrop)
    {
        return Inertia::render('airdrops/Edit', [
            'airdrop' => $airdrop,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $airdrop = Airdrop::create($request->toArray());

        return redirect()->intended(route('airdrops.edit', ['airdrop' => $airdrop->id]));
    }

    public function destroy(Airdrop $airdrop)
    {
        $airdrop->delete();

        return redirect()->intended(route('airdrops.index'));
    }
}
