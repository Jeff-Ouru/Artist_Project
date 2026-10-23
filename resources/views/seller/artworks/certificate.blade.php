<x-app-layout>
    <style>
        @media print {
            @page {
                size: A4;
                margin: 18mm;
            }

            body * {
                visibility: hidden !important;
            }

            #certificate,
            #certificate * {
                visibility: visible !important;
            }

            #certificate {
                position: absolute;
                inset: 0;
                width: 100%;
                border: 0;
                box-shadow: none;
            }

            #certificate-actions {
                display: none !important;
            }
        }
    </style>

    <main class="bright-theme min-h-screen bg-slate-100 px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl">
            <div id="certificate-actions" class="mb-6 flex items-center justify-between gap-4">
                <a href="{{ route('seller.artworks.index') }}#certificates" class="text-sm font-semibold text-slate-600 hover:text-slate-900">← Back to my listings</a>
                <button type="button" onclick="window.print()" class="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-700">Print / Save PDF</button>
            </div>

            <article id="certificate" class="rounded-2xl border-4 border-double border-amber-700 bg-white p-8 shadow-sm sm:p-14">
                <div class="text-center">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-amber-700">Certificate of Authenticity</p>
                    <h1 class="mt-5 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl">{{ $artwork->title }}</h1>
                    <p class="mt-3 text-sm text-slate-500">Certificate No. {{ sprintf('COA-%06d', $artwork->id) }}</p>
                </div>

                @php($certificateImage = $artwork->images->first()?->url ?? $artwork->image_url)
                @if ($certificateImage)
                    <div class="mx-auto mt-8 max-w-sm overflow-hidden rounded-xl border border-slate-200">
                        <img src="{{ $certificateImage }}" alt="{{ $artwork->title }}" class="aspect-[4/3] w-full object-cover">
                    </div>
                @endif

                <dl class="mx-auto mt-8 grid max-w-2xl gap-5 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">Artist</dt>
                        <dd class="mt-1 text-base font-medium text-slate-900">{{ $artwork->seller->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">Medium / description</dt>
                        <dd class="mt-1 text-base font-medium text-slate-900">{{ $artwork->description }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">Listed value</dt>
                        <dd class="mt-1 text-base font-medium text-slate-900">{{ $artwork->currency }} {{ number_format((float) $artwork->price, 2) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">Date issued</dt>
                        <dd class="mt-1 text-base font-medium text-slate-900">{{ now()->format('F j, Y') }}</dd>
                    </div>
                </dl>

                <p class="mx-auto mt-8 max-w-2xl text-center text-sm leading-6 text-slate-600">
                    This document records that the artwork identified above is represented in the artist’s studio inventory under the certificate number shown.
                </p>

                <div class="mx-auto mt-12 grid max-w-2xl gap-8 sm:grid-cols-2">
                    <div class="border-t border-slate-400 pt-2 text-sm text-slate-600">Artist signature: {{ $artwork->seller->name }}</div>
                    <div class="border-t border-slate-400 pt-2 text-sm text-slate-600">Issued by {{ config('app.name') }}</div>
                </div>
            </article>
        </div>
    </main>
</x-app-layout>
