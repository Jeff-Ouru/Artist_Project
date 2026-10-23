<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Artist Atelier') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="flex min-h-screen flex-col bg-blue-50/50 text-slate-900 antialiased">
    <div class="bg-gradient-to-br from-blue-950 via-blue-800 to-blue-700">
        @include('layouts.navbar')

        <main>
            <section class="px-6 pb-20 pt-12 sm:pb-28 sm:pt-20 lg:pb-32">
                <div class="mx-auto grid max-w-7xl items-center gap-12 lg:grid-cols-[1.15fr_0.85fr]">
                    <div class="max-w-2xl">
                        <p class="inline-flex items-center gap-2 rounded-full border border-blue-200/25 bg-white/10 px-4 py-2 text-sm font-medium text-blue-100">
                            <span class="h-2 w-2 rounded-full bg-sky-300" aria-hidden="true"></span>
                            Original art, from independent artists
                        </p>
                        <h1 class="mt-7 text-4xl font-semibold leading-tight tracking-tight text-white sm:text-5xl lg:text-6xl">
                            Find art that feels like it belongs to you.
                        </h1>
                        <p class="mt-6 max-w-xl text-lg leading-8 text-blue-100">
                            Discover original work, meet the artists behind it, and bring a more personal touch to your space.
                        </p>
                        <div class="mt-9 flex flex-wrap items-center gap-4">
                            <a href="{{ route('artworks.index') }}" class="inline-flex min-h-12 items-center justify-center rounded-xl bg-white px-6 py-3 text-sm font-semibold text-blue-900 shadow-lg shadow-blue-950/20 transition hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                                Browse artworks
                            </a>
                            <a href="{{ route('about') }}" class="inline-flex min-h-12 items-center justify-center rounded-xl border border-white/30 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                                Discover our story
                            </a>
                        </div>
                        <p class="mt-6 text-sm text-blue-200">
                            A thoughtful marketplace made for artists and collectors.
                        </p>
                    </div>

                    <div class="relative mx-auto w-full max-w-lg">
                        <div class="absolute -inset-4 rounded-[2rem] bg-sky-300/15 blur-2xl" aria-hidden="true"></div>
                        <div class="relative rounded-[1.75rem] border border-white/20 bg-white/10 p-5 shadow-2xl shadow-blue-950/30 backdrop-blur-sm sm:p-7">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="text-sm font-medium text-blue-100">A place for original work</p>
                                    <h2 class="mt-1 text-xl font-semibold text-white">Made with meaning</h2>
                                </div>
                                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white/15 text-sky-100" aria-hidden="true">
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m9 10 2 2 4-4" />
                                    </svg>
                                </span>
                            </div>
                            <div class="mt-6 grid grid-cols-2 gap-3">
                                <div class="flex aspect-[4/5] items-end rounded-2xl bg-gradient-to-br from-sky-200 via-blue-300 to-indigo-500 p-4">
                                    <span class="rounded-full bg-white/85 px-3 py-1.5 text-xs font-semibold text-blue-900">Original pieces</span>
                                </div>
                                <div class="mt-8 flex aspect-[4/5] items-end rounded-2xl bg-gradient-to-br from-cyan-100 via-teal-300 to-blue-500 p-4">
                                    <span class="rounded-full bg-white/85 px-3 py-1.5 text-xs font-semibold text-blue-900">Artist stories</span>
                                </div>
                            </div>
                            <p class="mt-5 text-sm leading-6 text-blue-100">
                                Every piece has a person, a process, and a story behind it.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    @if (isset($artworks) && $artworks->isNotEmpty())
        <section class="px-6 py-16 sm:py-20 lg:py-24">
            <div class="mx-auto max-w-7xl">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-700">A few favorites</p>
                        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl">Discover original work</h2>
                        <p class="mt-3 max-w-2xl leading-7 text-slate-600">Take a first look at pieces shared by our independent artists.</p>
                    </div>
                    <a href="{{ route('artworks.index') }}" class="inline-flex items-center gap-2 self-start rounded-xl px-4 py-2.5 text-sm font-semibold text-blue-700 transition hover:bg-blue-100 hover:text-blue-900 sm:self-auto">
                        Browse all artwork
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.69L10.22 5.03a.75.75 0 1 1 1.06-1.06l5.5 5.5a.75.75 0 0 1 0 1.06l-5.5 5.5a.75.75 0 1 1-1.06-1.06l4.22-4.22H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>

                <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($artworks as $artwork)
                        @php($imageUrl = $artwork->images->firstWhere('is_primary', true)?->url ?? $artwork->images->first()?->url ?? $artwork->image_url)
                        <article class="group overflow-hidden rounded-2xl border border-blue-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg hover:shadow-blue-950/10">
                            <a href="{{ route('artworks.show', $artwork) }}" class="block">
                                <div class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-blue-100 via-sky-100 to-indigo-100">
                                    @if ($imageUrl)
                                        <img src="{{ $imageUrl }}" alt="{{ $artwork->images->firstWhere('is_primary', true)?->alt_text ?? $artwork->title }}" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                    @else
                                        <div class="flex h-full items-center justify-center text-blue-400">
                                            <svg class="h-12 w-12" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                                <rect x="7" y="7" width="34" height="34" rx="5" />
                                                <circle cx="18" cy="18" r="3" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m9 35 10-10 7 7 5-5 8 8" />
                                            </svg>
                                        </div>
                                    @endif
                                    <span @class([
                                        'absolute left-3 top-3 rounded-full px-3 py-1.5 text-xs font-semibold',
                                        'bg-emerald-100 text-emerald-800' => $artwork->status === 'available',
                                        'bg-slate-900/85 text-white' => $artwork->status === 'sold',
                                    ])>{{ $artwork->status === 'available' ? 'Available' : 'Sold' }}</span>
                                </div>
                                <div class="p-5">
                                    <h3 class="truncate font-semibold text-slate-900 group-hover:text-blue-800">{{ $artwork->title }}</h3>
                                    <p class="mt-1 text-sm text-slate-500">by {{ $artwork->seller->name }}</p>
                                    <p class="mt-4 border-t border-slate-100 pt-4 text-sm font-semibold text-slate-900">{{ $artwork->currency }} {{ number_format((float) $artwork->price, 2) }}</p>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="px-6 py-16 sm:py-20 lg:py-24">
        <div class="mx-auto max-w-7xl">
            <div class="max-w-2xl">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-700">A better way to collect</p>
                <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl">Good art is about more than what’s on the wall.</h2>
                <p class="mt-4 text-base leading-7 text-slate-600">
                    Explore work with its story attached, connect directly with creators, and support independent artistic practices.
                </p>
            </div>

            <div class="mt-10 grid gap-5 md:grid-cols-3 md:gap-6">
                <article class="rounded-2xl border border-blue-100 bg-white p-6 shadow-sm sm:p-7">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-100 text-sm font-bold text-blue-800" aria-hidden="true">01</span>
                    <h3 class="mt-5 text-lg font-semibold text-slate-900">Find your piece</h3>
                    <p class="mt-2 leading-7 text-slate-600">Browse original artworks and discover new makers across styles and mediums.</p>
                </article>
                <article class="rounded-2xl border border-blue-100 bg-white p-6 shadow-sm sm:p-7">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-100 text-sm font-bold text-blue-800" aria-hidden="true">02</span>
                    <h3 class="mt-5 text-lg font-semibold text-slate-900">Meet the artist</h3>
                    <p class="mt-2 leading-7 text-slate-600">Learn about the creator, their process, and the details that make each work one of a kind.</p>
                </article>
                <article class="rounded-2xl border border-blue-100 bg-white p-6 shadow-sm sm:p-7">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-100 text-sm font-bold text-blue-800" aria-hidden="true">03</span>
                    <h3 class="mt-5 text-lg font-semibold text-slate-900">Collect with confidence</h3>
                    <p class="mt-2 leading-7 text-slate-600">Clear artwork details and direct conversations help you choose a piece you’ll love.</p>
                </article>
            </div>

            <div class="mt-10 flex flex-col gap-5 rounded-2xl bg-blue-100/70 p-6 sm:flex-row sm:items-center sm:justify-between sm:p-8">
                <div>
                    <h2 class="text-xl font-semibold text-blue-950">Ready to find something original?</h2>
                    <p class="mt-1 text-blue-900/75">Explore the collection and meet the artists behind the work.</p>
                </div>
                <a href="{{ route('artworks.index') }}" class="inline-flex min-h-11 shrink-0 items-center justify-center rounded-xl bg-blue-700 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700">
                    Explore artworks
                </a>
            </div>
        </div>
    </section>

    <x-footer />
</body>
</html>
