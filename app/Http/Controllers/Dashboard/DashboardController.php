<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $currentMonth = auth()->user()->invitees()->whereBetween('created_at', [
            now()->startOfMonth(),
            now()->endOfMonth(),
        ])->count();

        $lastMonth = auth()->user()->invitees()->whereBetween('created_at', [
            now()->subMonth()->startOfMonth(),
            now()->subMonth()->endOfMonth(),
        ])->count();

        return Inertia::render('Dashboard', [
            'total_invitees' => $currentMonth,
            'percentage' => $lastMonth > 0 ? (($currentMonth - $lastMonth) / $lastMonth) * 100 : ($currentMonth > 0 ? 100 : 0),
        ]);
    }
}
