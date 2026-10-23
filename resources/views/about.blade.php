<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About — Artist Atelier</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="flex min-h-screen flex-col bg-white text-slate-900 antialiased">
    @include('layouts.navbar')

    <main class="flex-1">
        <section class="bg-slate-50 px-6 py-20 sm:py-28">
            <div class="mx-auto max-w-4xl">
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-amber-700">About Artist Atelier</p>
                <h1 class="mt-4 max-w-3xl text-4xl font-semibold leading-tight tracking-tight sm:text-6xl">
                    Art deserves a more thoughtful place to be found.
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-600">
                    We connect independent artists with people who want to live with original work — and know the story behind it.
                </p>
            </div>
        </section>

        <div class="mx-auto max-w-4xl space-y-16 px-6 py-16 sm:py-20">
            <section aria-labelledby="our-story">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-amber-700">Our Story</p>
                <h2 id="our-story" class="mt-3 text-2xl font-semibold tracking-tight sm:text-3xl">A marketplace built around the people who make art.</h2>
                <p class="mt-5 text-base leading-8 text-slate-600">
                    Artist Atelier began with a simple frustration: the internet made it easier than ever to see art, but harder than ever to find it. Great work was getting buried under algorithm-driven feeds, mass-produced prints, and marketplaces that treated paintings like commodity listings. We wanted to build the opposite — a slower, more intentional space where artists can show their work with context and collectors can buy with confidence.
                </p>
                <p class="mt-4 text-base leading-8 text-slate-600">
                    Every artist on our platform is reviewed before joining. Every piece is uploaded by the person who made it, with details about the materials, the process, and the story behind it. Nothing is anonymous. Nothing is mass-produced.
                </p>
            </section>

            <section aria-labelledby="what-we-believe" class="border-t border-slate-200 pt-12">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-amber-700">What we believe</p>
                <h2 id="what-we-believe" class="mt-3 text-2xl font-semibold tracking-tight sm:text-3xl">Personal, transparent, and artist-first.</h2>
                <div class="mt-8 grid gap-8 sm:grid-cols-2">
                    <article>
                        <h3 class="text-lg font-semibold">Artists come first</h3>
                        <p class="mt-2 leading-7 text-slate-600">Artists keep the majority of every sale. Our fees are clear — no hidden commissions or surprise deductions.</p>
                    </article>
                    <article>
                        <h3 class="text-lg font-semibold">Curation over volume</h3>
                        <p class="mt-2 leading-7 text-slate-600">We review every application and look for original work, thoughtful presentation, and a consistent practice — not follower counts.</p>
                    </article>
                    <article>
                        <h3 class="text-lg font-semibold">Transparency by default</h3>
                        <p class="mt-2 leading-7 text-slate-600">Materials, dimensions, shipping details, and provenance help collectors know what they are choosing.</p>
                    </article>
                    <article>
                        <h3 class="text-lg font-semibold">Real connection</h3>
                        <p class="mt-2 leading-7 text-slate-600">Direct communication makes it easy for collectors to ask questions and for artists to share the meaning behind their work.</p>
                    </article>
                </div>
            </section>

            <section aria-labelledby="how-it-works" class="border-t border-slate-200 pt-12">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-amber-700">How it works</p>
                <h2 id="how-it-works" class="mt-3 text-2xl font-semibold tracking-tight sm:text-3xl">A simpler way to share and collect original art.</h2>
                <div class="mt-8 grid gap-8 sm:grid-cols-2">
                    <div>
                        <h3 class="text-lg font-semibold">For artists</h3>
                        <p class="mt-2 leading-7 text-slate-600">Create a profile, share your work with its details, and reach collectors looking for original pieces. When a piece sells, you are notified and can arrange its delivery.</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">For collectors</h3>
                        <p class="mt-2 leading-7 text-slate-600">Explore by medium, style, or artist, ask creators questions directly, and purchase securely. Every purchase supports an independent artistic practice.</p>
                    </div>
                </div>
                <a href="{{ route('artworks.index') }}" class="mt-8 inline-flex items-center rounded-md bg-gray-800 px-5 py-3 font-medium text-white transition hover:bg-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-800">
                    Explore the artworks
                </a>
            </section>
        </div>
    </main>

    <x-footer />
</body>
</html>
