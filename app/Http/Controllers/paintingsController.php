<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Painting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PaintingsController extends Controller
{
    public function index(Request $request): View
    {
        $paintings = Painting::with('artwork')->latest()->get();

        return view('paintings.index', compact('paintings'));
    }

    public function create(): View
    {
        return view('paintings.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'description' => ['required', 'string', 'max:5000'],
            'image_url' => ['nullable', 'url', 'max:2048'],
            'images' => ['nullable', 'array', 'max:5'],
            'images.*' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
        ]);

        $uploads = $validated['images'] ?? [];
        unset($validated['images']);

        $painting = Painting::create($validated);
        $storedPaths = [];

        foreach ($uploads as $upload) {
            $path = $upload->store('paintings/images');
            $storedPaths[] = $path;
        }

        // Assuming you have a relationship to store images
        if (!empty($storedPaths)) {
            $painting->images()->createMany(array_map(fn($path) => ['path' => $path], $storedPaths));
        }

        return redirect()->route('paintings.index')->with('success', 'Painting created successfully.');
    }
}