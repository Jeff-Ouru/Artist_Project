<footer class="border-t border-slate-200 bg-white" >
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">

            {{-- Brand --}}
            <div>
                <a href="{{ url('/') }}" class="text-lg font-semibold text-slate-900">
                    {{ config('app.name') }}
                </a>
                <p class="mt-3 text-sm text-slate-500">
                    Discover and collect original artwork from independent artists.
                </p>
            </div>

            {{-- Explore --}}
            <div>
                <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Explore</h3>
                <ul class="mt-3 space-y-2 text-sm text-slate-600">
                    <li><a href="{{ route('artworks.index') }}" class="hover:text-slate-900">All artworks</a></li>
                    <li><a href="#" class="hover:text-slate-900">Artists</a></li>
                    <li><a href="#" class="hover:text-slate-900">Categories</a></li>
                </ul>
            </div>

            {{-- Company --}}
            <div>
                <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Company</h3>
                <ul class="mt-3 space-y-2 text-sm text-slate-600">
                    <li><a href="#" class="hover:text-slate-900">About</a></li>
                    <li><a href="#" class="hover:text-slate-900">Contact</a></li>
                    <li><a href="#" class="hover:text-slate-900">Privacy</a></li>
                </ul>
            </div>

            {{-- Social --}}
            <div>
                <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Follow</h3>
                <div class="mt-3 flex gap-3">
                    <a href="#" aria-label="Facebook" class="text-slate-500 hover:text-slate-900">FB</a>
                    <a href="#" aria-label="Instagram" class="text-slate-500 hover:text-slate-900">IG</a>
                    <a href="#" aria-label="X" class="text-slate-500 hover:text-slate-900">X</a>
                </div>
            </div>
        </div>

        <div class="mt-10 border-t border-slate-100 pt-6 text-center text-xs text-slate-500">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</footer>