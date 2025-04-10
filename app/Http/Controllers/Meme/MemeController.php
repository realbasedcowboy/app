<?php

namespace App\Http\Controllers\Meme;

use App\Domains\Meme\Models\Meme;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class MemeController extends Controller
{
    public function index()
    {
        return Inertia::render('meme/Index');
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['required', 'image', 'max:2048'],
        ]);

        $user = $request->user();

        /** @var Meme $meme */
        $meme = $user->memes()->create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        $meme->addMediaFromRequest('image')->toMediaCollection('images');

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
