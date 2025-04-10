<?php

namespace App\Http\Controllers\Meme;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MemeController extends Controller
{
    public function index()
    {
        return Inertia::render('meme/Index');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['required', 'image', 'max:2048'],
        ]);

        $path = $request->file('image')->store('memes', 'public');

        $user = $request->user();

        $user->memes()->create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $path,
        ]);

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
