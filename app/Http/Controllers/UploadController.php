<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtworkController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:160'],
            'description' => ['required', 'string', 'max:5000'],
            'image_url'   => ['nullable', 'url', 'max:2048'],
            'images'      => ['nullable', 'array', 'max:5'],
            'images.*'    => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'price'       => ['required', 'numeric', 'min:0'],
            'currency'    => ['required', 'string', 'size:3'],
        ]);

        // Create the artwork WITHOUT the file inputs
        $files = $validated['images'] ?? [];
        unset($validated['images']);

        $artwork = $request->user()->artworks()->create($validated);

        // Store each uploaded image and save path to DB
        $storedPaths = [];
        foreach ($files as $file) {
            $storedPaths[] = $file->store('artworks', 'public');
        }

        // Now decide how to persist $storedPaths
        // Option A: if your artworks table has an "image" column, save the first one:
        if (!empty($storedPaths)) {
            $artwork->update(['image' => $storedPaths[0]]);
        }

        // Option B: if you have a separate "artwork_images" table / relation,
        // loop over $storedPaths and create related rows. Example:
        //
        // foreach ($storedPaths as $path) {
        //     $artwork->images()->create(['path' => $path]);
        // }

        return redirect()
            ->route('artworks.show', $artwork)
            ->with('success', 'Artwork created successfully.');
    }
}