<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        return Inertia::render('Dashboard', [
            'memes' => $user->memes->all(),
        ]);
    }
}
