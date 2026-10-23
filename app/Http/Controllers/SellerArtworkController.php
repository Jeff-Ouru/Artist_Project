<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SellerArtworkController extends Controller
{
    public function index(Request $request): View
    {
        $artworks = $request->user()->artworks()->withCount('inquiries')->latest()->get();

        return view('seller.artworks.index', compact('artworks'));
    }

    public function create(): View
    {
        return view('seller.artworks.create');
    }

    public function edit(Request $request, Artwork $artwork): View
    {
        abort_unless($artwork->seller_id === $request->user()->id, 403);

        return view('seller.artworks.edit', [
            'artwork' => $artwork->load('images'),
        ]);
    }

    public function certificate(Request $request, Artwork $artwork): View
    {
        abort_unless($artwork->seller_id === $request->user()->id, 403);

        return view('seller.artworks.certificate', compact('artwork'));
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

        $artwork = $request->user()->artworks()->create($validated);
        $storedPaths = [];

        try {
            foreach ($uploads as $sortOrder => $upload) {
                if (! $upload instanceof UploadedFile) {
                    continue;
                }

                $path = $upload->store('artworks', 'public');

                if (! is_string($path)) {
                    throw new \RuntimeException('The artwork image could not be saved.');
                }

                $storedPaths[] = $path;

                $artwork->images()->create([
                    'path' => $path,
                    'disk' => 'public',
                    'alt_text' => $artwork->title,
                    'size_bytes' => $upload->getSize(),
                    'is_primary' => $sortOrder === 0,
                    'sort_order' => $sortOrder,
                ]);

                if ($sortOrder === 0 && empty($artwork->image_url)) {
                    $artwork->update(['image_url' => Storage::disk('public')->url($path)]);
                }
            }
        } catch (\Throwable $exception) {
            Storage::disk('public')->delete($storedPaths);
            $artwork->delete();

            throw $exception;
        }

        return redirect()->route('seller.artworks.index')->with('success', 'Artwork listed for sale.');
    }

    public function update(Request $request, Artwork $artwork): RedirectResponse
    {
        abort_unless($artwork->seller_id === $request->user()->id, 403);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'description' => ['required', 'string', 'max:5000'],
            'image_url' => ['nullable', 'url', 'max:2048'],
            'images' => ['nullable', 'array', 'max:5'],
            'images.*' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'remove_images' => ['nullable', 'boolean'],
        ]);

        $uploads = $validated['images'] ?? [];
        $removeImages = (bool) ($validated['remove_images'] ?? false);
        unset($validated['images'], $validated['remove_images']);

        if ($removeImages && $uploads === [] && ($validated['image_url'] ?? null) === $artwork->image_url) {
            $validated['image_url'] = null;
        }

        $replaceImages = $uploads !== [] || $removeImages;
        $oldImages = $replaceImages ? $artwork->images()->get() : collect();
        $newImages = [];
        $newPaths = [];

        try {
            foreach ($uploads as $sortOrder => $upload) {
                if (! $upload instanceof UploadedFile) {
                    continue;
                }

                $path = $upload->store('artworks', 'public');

                if (! is_string($path)) {
                    throw new \RuntimeException('The artwork image could not be saved.');
                }

                $newPaths[] = $path;
                $newImages[] = [
                    'path' => $path,
                    'disk' => 'public',
                    'alt_text' => $validated['title'],
                    'size_bytes' => $upload->getSize(),
                    'is_primary' => $sortOrder === 0,
                    'sort_order' => $sortOrder,
                ];
            }

            DB::transaction(function () use ($artwork, $validated, $replaceImages, $newImages, $newPaths) {
                if ($replaceImages) {
                    $artwork->images()->delete();
                    $artwork->images()->createMany($newImages);
                }

                if ($newPaths !== []) {
                    $validated['image_url'] = Storage::disk('public')->url($newPaths[0]);
                }

                $artwork->update($validated);
            });
        } catch (\Throwable $exception) {
            Storage::disk('public')->delete($newPaths);

            throw $exception;
        }

        $this->deleteImageFiles($oldImages);

        return redirect()->route('seller.artworks.index')->with('success', 'Artwork updated successfully.');
    }

    public function destroy(Request $request, Artwork $artwork): RedirectResponse
    {
        abort_unless($artwork->seller_id === $request->user()->id, 403);

        $images = $artwork->images()->get();

        DB::transaction(function () use ($artwork) {
            $artwork->images()->delete();
            $artwork->delete();
        });

        $this->deleteImageFiles($images);

        return redirect()->route('seller.artworks.index')->with('success', 'Artwork deleted successfully.');
    }

    public function updateStatus(Request $request, Artwork $artwork): RedirectResponse
    {
        abort_unless($artwork->seller_id === $request->user()->id, 403);

        $validated = $request->validate([
            'status' => ['required', 'in:available,sold'],
        ]);

        $artwork->update($validated);

        return back()->with('success', 'Artwork status updated.');
    }

    private function deleteImageFiles(iterable $images): void
    {
        foreach ($images as $image) {
            $disk = Storage::disk($image->disk);
            $disk->delete($image->path);

            $thumbnail = preg_replace('/(\.[a-z0-9]+)$/i', '_thumb$1', $image->path);
            $disk->delete($thumbnail);
        }
    }
}
