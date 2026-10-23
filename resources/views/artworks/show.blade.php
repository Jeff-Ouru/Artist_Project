<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $artwork->title }} — {{ config('app.name', 'Artist Atelier') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="flex min-h-screen flex-col bg-blue-50/50 text-slate-900 antialiased">
    @include('layouts.navbar')

    <main class="flex-1 px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <a href="{{ route('artworks.index') }}" class="inline-flex items-center gap-2 rounded-lg text-sm font-semibold text-blue-700 transition hover:text-blue-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700">
                <svg class="h-4 w-4 rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.69L10.22 5.03a.75.75 0 1 1 1.06-1.06l5.5 5.5a.75.75 0 0 1 0 1.06l-5.5 5.5a.75.75 0 1 1-1.06-1.06l4.22-4.22H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
                </svg>
                Back to artworks
            </a>

            @if (session('success'))
                <div role="status" class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
            @endif

            <div class="mt-7 grid items-start gap-8 lg:grid-cols-[minmax(0,1.2fr)_minmax(20rem,0.8fr)] lg:gap-12">
                <section aria-label="Artwork images">
                    @php($primaryImage = $artwork->images->firstWhere('is_primary', true) ?? $artwork->images->first())
                    <div class="overflow-hidden rounded-3xl border border-blue-100 bg-gradient-to-br from-blue-100 via-sky-100 to-indigo-100 shadow-sm">
                        @if ($primaryImage || $artwork->image_url)
                            <img src="{{ $primaryImage?->url ?? $artwork->image_url }}" alt="{{ $primaryImage?->alt_text ?? $artwork->title }}" class="aspect-[4/3] max-h-[42rem] w-full object-cover">
                        @else
                            <div class="flex aspect-[4/3] max-h-[42rem] flex-col items-center justify-center gap-4 text-blue-500">
                                <svg class="h-16 w-16" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <rect x="7" y="7" width="34" height="34" rx="5" />
                                    <circle cx="18" cy="18" r="3" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m9 35 10-10 7 7 5-5 8 8" />
                                </svg>
                                <span class="text-sm font-medium">Artwork image coming soon</span>
                            </div>
                        @endif
                    </div>

                    @if ($artwork->images->count() > 1)
                        <div class="mt-4 grid grid-cols-4 gap-3 sm:grid-cols-5">
                            @foreach ($artwork->images as $image)
                                @if ($image->id !== $primaryImage?->id)
                                    <img src="{{ $image->url }}" alt="{{ $image->alt_text ?? $artwork->title }}" loading="lazy" class="aspect-square w-full rounded-xl border border-blue-100 bg-white object-cover">
                                @endif
                            @endforeach
                        </div>
                    @endif
                </section>

                <div class="space-y-6">
                    <section class="rounded-3xl border border-blue-100 bg-white p-6 shadow-sm sm:p-8">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <span @class([
                                'rounded-full px-3 py-1.5 text-xs font-semibold',
                                'bg-emerald-100 text-emerald-800' => $artwork->status === 'available',
                                'bg-slate-100 text-slate-700' => $artwork->status === 'sold',
                            ])>{{ $artwork->status === 'available' ? 'Available' : 'Sold' }}</span>
                            <span class="text-xs font-medium uppercase tracking-[0.15em] text-slate-400">Original artwork</span>
                        </div>

                        <h1 class="mt-5 text-3xl font-semibold leading-tight tracking-tight text-slate-900 sm:text-4xl">{{ $artwork->title }}</h1>
                        <p class="mt-4 text-2xl font-semibold text-blue-800">{{ $artwork->currency }} {{ number_format((float) $artwork->price, 2) }}</p>

                        <div class="mt-6 border-t border-slate-100 pt-6">
                            <h2 class="text-sm font-semibold uppercase tracking-[0.15em] text-slate-500">About this piece</h2>
                            <p class="mt-3 whitespace-pre-line leading-7 text-slate-700">{{ $artwork->description }}</p>
                        </div>

                        <div class="mt-7 flex items-center gap-4 border-t border-slate-100 pt-6">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-blue-100 text-base font-semibold text-blue-800">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($artwork->seller->name, 0, 1)) }}</span>
                            <div class="min-w-0">
                                <p class="text-xs font-medium uppercase tracking-[0.12em] text-slate-500">Created by</p>
                                <p class="mt-0.5 truncate font-semibold text-slate-900">{{ $artwork->seller->name }}</p>
                            </div>
                        </div>
                    </section>

                    @if ($artwork->isAvailable())
                        <section class="rounded-3xl border border-blue-100 bg-white p-6 shadow-sm sm:p-8">
                            <h2 class="text-xl font-semibold text-slate-900">Interested in this artwork?</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Send the artist a message to ask a question or discuss this piece.</p>

                            <form method="POST" action="{{ route('artworks.inquiries.store', $artwork) }}" class="mt-6 space-y-4">
                                @csrf
                                <div>
                                    <label for="buyer_name" class="block text-sm font-medium text-slate-700">Your name</label>
                                    <input id="buyer_name" name="buyer_name" type="text" value="{{ old('buyer_name', auth()->user()?->name) }}" required maxlength="120" autocomplete="name" class="mt-1.5 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-600 focus:ring-blue-600">
                                    @error('buyer_name')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="buyer_email" class="block text-sm font-medium text-slate-700">Email address</label>
                                    <input id="buyer_email" name="buyer_email" type="email" value="{{ old('buyer_email', auth()->user()?->email) }}" required maxlength="255" autocomplete="email" class="mt-1.5 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-600 focus:ring-blue-600">
                                    @error('buyer_email')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="message" class="block text-sm font-medium text-slate-700">Message to the artist</label>
                                    <textarea id="message" name="message" rows="4" required maxlength="2000" class="mt-1.5 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-600 focus:ring-blue-600">{{ old('message') }}</textarea>
                                    @error('message')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <button type="submit" class="inline-flex min-h-12 w-full items-center justify-center rounded-xl bg-blue-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700">
                                    Contact seller about this artwork
                                </button>
                            </form>
                        </section>
                    @else
                        <div class="rounded-2xl border border-slate-200 bg-slate-100 p-5 text-sm font-medium text-slate-700">
                            This artwork has been sold.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <x-footer />
</body>
</html>
