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

    public function vote(Meme $meme, Request $request)
    {
        $request->validate([
            'vote' => 'required|in:like,dislike',
        ]);

        $user = $request->user();

        $meme->likes()->updateOrCreate([
            'user_id' => $user->id,
            'meme_id' => $meme->id,
        ], [
            'is_liked' => $request->vote === 'like',
        ]);

        // Get the total likes and dislikes
        $likesCount = $meme->likes()->where('is_liked', 1)->count();
        $dislikesCount = $meme->likes()->where('is_liked', 0)->count();

        // Return the counts as a response
        return response()->json([
            'likes' => $likesCount,
            'dislikes' => $dislikesCount,
        ]);
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
