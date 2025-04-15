<?php

namespace App\Http\Controllers\Dashboard;

use App\Domains\Meme\Models\Meme;
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
            'memes' => Meme::withCount([
                'likes as likes' => function ($query) {
                    $query->where('is_liked', 1);
                },
                'likes as dislikes' => function ($query) {
                    $query->where('is_liked', 0);
                },
            ])
                ->with('media') // Ensure related media is eager-loaded
                ->latest() // Ensure the memes are ordered by the latest ones
                ->get(), // Retrieve all memes
        ]);
    }
}
