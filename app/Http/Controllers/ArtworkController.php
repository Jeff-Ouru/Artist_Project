<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArtworkController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:all,available,sold'],
            'sort' => ['nullable', 'in:newest,price_asc,price_desc'],
        ]);

        $query = Artwork::with(['seller', 'images']);
        $search = trim($filters['q'] ?? '');
        $status = $filters['status'] ?? 'all';
        $sort = $filters['sort'] ?? 'newest';

        if ($search !== '') {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('seller', fn ($seller) => $seller->where('name', 'like', "%{$search}%"));
            });
        }

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        match ($sort) {
            'price_asc' => $query->orderBy('price')->orderByDesc('created_at'),
            'price_desc' => $query->orderByDesc('price')->orderByDesc('created_at'),
            default => $query->latest(),
        };

        return view('artworks.index', [
            'artworks' => $query->paginate(12)->withQueryString(),
            'filters' => [
                'q' => $search,
                'status' => $status,
                'sort' => $sort,
            ],
        ]);
    }

    public function show(Artwork $artwork): View
    {
        return view('artworks.show', [
            'artwork' => $artwork->load(['seller', 'images']),
        ]);
    }
}
