<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Browse Art — {{ config('app.name', 'Artist Atelier') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="flex min-h-screen flex-col bg-blue-50/50 text-slate-900 antialiased">
    @include('layouts.navbar')

    <main class="flex-1">
        <section class="bg-gradient-to-br from-blue-950 via-blue-800 to-blue-700 px-6 py-14 text-white sm:py-20">
            <div class="mx-auto max-w-7xl">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-200">The collection</p>
                <div class="mt-3 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                    <div class="max-w-2xl">
                        <h1 class="text-4xl font-semibold tracking-tight sm:text-5xl">Find a piece that speaks to you.</h1>
                        <p class="mt-4 max-w-xl text-base leading-7 text-blue-100 sm:text-lg">
                            Explore original work from independent artists and discover the story behind every piece.
                        </p>
                    </div>
                    <a href="{{ route('about') }}" class="inline-flex shrink-0 items-center gap-2 self-start rounded-xl border border-white/25 px-4 py-3 text-sm font-semibold text-white transition hover:bg-white/10 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white sm:self-auto">
                        Meet Artist Atelier
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.69L10.22 5.03a.75.75 0 1 1 1.06-1.06l5.5 5.5a.75.75 0 0 1 0 1.06l-5.5 5.5a.75.75 0 1 1-1.06-1.06l4.22-4.22H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <section class="px-4 py-10 sm:px-6 sm:py-14 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <form method="GET" action="{{ route('artworks.index') }}" class="rounded-2xl border border-blue-100 bg-white p-4 shadow-sm sm:p-5">
                    <div class="grid gap-4 md:grid-cols-[minmax(0,1fr)_auto_auto_auto] md:items-end">
                        <div>
                            <label for="artwork-search" class="mb-2 block text-sm font-semibold text-slate-700">Search the collection</label>
                            <div class="relative">
                                <svg class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <circle cx="11" cy="11" r="7" />
                                    <path stroke-linecap="round" d="m20 20-4-4" />
                                </svg>
                                <input id="artwork-search" type="search" name="q" value="{{ $filters['q'] }}" placeholder="Try a title, artist, or keyword" class="w-full rounded-xl border-slate-300 py-3 pl-11 pr-4 text-sm shadow-sm placeholder:text-slate-400 focus:border-blue-600 focus:ring-blue-600">
                            </div>
                        </div>
                        <div>
                            <label for="artwork-status" class="mb-2 block text-sm font-semibold text-slate-700">Availability</label>
                            <select id="artwork-status" name="status" class="w-full rounded-xl border-slate-300 py-3 pl-3 pr-9 text-sm shadow-sm focus:border-blue-600 focus:ring-blue-600">
                                <option value="all" @selected($filters['status'] === 'all')>All artwork</option>
                                <option value="available" @selected($filters['status'] === 'available')>Available</option>
                                <option value="sold" @selected($filters['status'] === 'sold')>Sold</option>
                            </select>
                        </div>
                        <div>
                            <label for="artwork-sort" class="mb-2 block text-sm font-semibold text-slate-700">Sort by</label>
                            <select id="artwork-sort" name="sort" class="w-full rounded-xl border-slate-300 py-3 pl-3 pr-9 text-sm shadow-sm focus:border-blue-600 focus:ring-blue-600">
                                <option value="newest" @selected($filters['sort'] === 'newest')>Recently added</option>
                                <option value="price_asc" @selected($filters['sort'] === 'price_asc')>Price: low to high</option>
                                <option value="price_desc" @selected($filters['sort'] === 'price_desc')>Price: high to low</option>
                            </select>
                        </div>
                        <button type="submit" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-xl bg-blue-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8.5 3a5.5 5.5 0 1 0 3.477 9.762l3.63 3.63a.75.75 0 1 0 1.06-1.06l-3.63-3.63A5.5 5.5 0 0 0 8.5 3ZM4.5 8.5a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z" clip-rule="evenodd" />
                            </svg>
                            Apply filters
                        </button>
                    </div>
                </form>

                <div class="mb-5 mt-9 flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-semibold tracking-tight text-slate-900">Artworks</h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Showing {{ $artworks->firstItem() ?? 0 }}–{{ $artworks->lastItem() ?? 0 }} of {{ $artworks->total() }} {{ \Illuminate\Support\Str::plural('piece', $artworks->total()) }}
                        </p>
                    </div>
                    @if ($filters['q'] !== '' || $filters['status'] !== 'all' || $filters['sort'] !== 'newest')
                        <a href="{{ route('artworks.index') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-100 hover:text-blue-900">Clear filters</a>
                    @endif
                </div>

                @if ($artworks->isNotEmpty())
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        @foreach ($artworks as $artwork)
                            @php($imageUrl = $artwork->images->firstWhere('is_primary', true)?->url ?? $artwork->images->first()?->url ?? $artwork->image_url)
                            <article class="group overflow-hidden rounded-2xl border border-blue-100 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg hover:shadow-blue-950/10">
                                <a href="{{ route('artworks.show', $artwork) }}" class="block focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-[-2px] focus-visible:outline-blue-700">
                                    <div class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-blue-100 via-sky-100 to-indigo-100">
                                        @if ($imageUrl)
                                            <img src="{{ $imageUrl }}" alt="{{ $artwork->images->firstWhere('is_primary', true)?->alt_text ?? $artwork->title }}" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                        @else
                                            <div class="flex h-full flex-col items-center justify-center gap-3 text-blue-400">
                                                <svg class="h-12 w-12" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                                    <rect x="7" y="7" width="34" height="34" rx="5" />
                                                    <circle cx="18" cy="18" r="3" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m9 35 10-10 7 7 5-5 8 8" />
                                                </svg>
                                                <span class="text-xs font-medium">Artwork image coming soon</span>
                                            </div>
                                        @endif
                                        <span @class([
                                            'absolute left-3 top-3 rounded-full px-3 py-1.5 text-xs font-semibold shadow-sm',
                                            'bg-emerald-100 text-emerald-800' => $artwork->status === 'available',
                                            'bg-slate-900/85 text-white' => $artwork->status === 'sold',
                                        ])>{{ $artwork->status === 'available' ? 'Available' : 'Sold' }}</span>
                                    </div>
                                    <div class="p-5">
                                        <div class="flex items-start justify-between gap-3">
                                            <h3 class="line-clamp-1 text-base font-semibold text-slate-900 transition group-hover:text-blue-800">{{ $artwork->title }}</h3>
                                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-slate-400 transition group-hover:translate-x-0.5 group-hover:text-blue-700" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.69L10.22 5.03a.75.75 0 1 1 1.06-1.06l5.5 5.5a.75.75 0 0 1 0 1.06l-5.5 5.5a.75.75 0 1 1-1.06-1.06l4.22-4.22H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <p class="mt-1 text-sm text-slate-500">by {{ $artwork->seller->name }}</p>
                                        <p class="mt-4 line-clamp-2 min-h-10 text-sm leading-5 text-slate-600">{{ $artwork->description }}</p>
                                        <div class="mt-5 flex items-center justify-between border-t border-slate-100 pt-4">
                                            <span class="text-sm font-semibold text-slate-900">{{ $artwork->currency }} {{ number_format((float) $artwork->price, 2) }}</span>
                                            <span class="text-xs font-medium text-blue-700">View details</span>
                                        </div>
                                    </div>
                                </a>
                                @auth
                                    @if (auth()->id() === $artwork->seller_id)
                                        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 border-t border-slate-100 px-5 py-3">
                                            <a href="{{ route('seller.artworks.edit', $artwork) }}" class="text-xs font-semibold text-slate-600 transition hover:text-blue-800">Edit listing</a>
                                            <form method="POST" action="{{ route('seller.artworks.status', $artwork) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="{{ $artwork->status === 'available' ? 'sold' : 'available' }}">
                                                <button type="submit" class="text-xs font-semibold text-slate-600 transition hover:text-blue-800">Mark {{ $artwork->status === 'available' ? 'sold' : 'available' }}</button>
                                            </form>
                                            <form method="POST" action="{{ route('seller.artworks.destroy', $artwork) }}" onsubmit="return confirm('Delete this artwork permanently?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs font-semibold text-red-600 transition hover:text-red-800">Delete</button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                            </article>
                        @endforeach
                    </div>

                    @if ($artworks->hasPages())
                        <div class="mt-10">
                            {{ $artworks->links() }}
                        </div>
                    @endif
                @else
                    <div class="rounded-3xl border border-dashed border-blue-200 bg-white px-6 py-16 text-center shadow-sm sm:px-12">
                        <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-100 text-blue-700">
                            <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                <circle cx="11" cy="11" r="7" />
                                <path stroke-linecap="round" d="m20 20-4-4M8 11h6" />
                            </svg>
                        </span>
                        <h2 class="mt-5 text-xl font-semibold text-slate-900">No artwork found</h2>
                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-600">Try a different search or adjust the availability filters to explore more of the collection.</p>
                        <a href="{{ route('artworks.index') }}" class="mt-6 inline-flex rounded-xl bg-blue-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-800">Clear filters</a>
                    </div>
                @endif
            </div>
        </section>
    </main>

    <x-footer />
</body>
</html>
