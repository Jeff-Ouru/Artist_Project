@php
    $navLinks = [
        ['label' => 'Home', 'route' => 'home', 'active' => 'home'],
        ['label' => 'Browse art', 'route' => 'artworks.index', 'active' => 'artworks.*'],
        ['label' => 'Seller listings', 'route' => 'seller.artworks.index', 'active' => 'seller.artworks.*'],
        ['label' => 'About', 'route' => 'about', 'active' => 'about'],
    ];
@endphp

<header class="px-4 pt-4 sm:px-6 sm:pt-6">
    <nav aria-label="Main navigation" class="relative mx-auto max-w-7xl rounded-2xl bg-blue-700 px-5 py-4 text-white shadow-lg shadow-blue-950/10 sm:px-7">
        <div class="flex flex-wrap items-center justify-between gap-4 lg:flex-nowrap lg:gap-3">
            <a href="{{ route('home') }}" class="group inline-flex items-center gap-3 rounded-lg focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-white">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/15 text-lg font-bold tracking-tight text-white ring-1 ring-inset ring-white/20 transition group-hover:bg-white/25" aria-hidden="true">A</span>
                <span>
                    <span class="block text-base font-semibold leading-tight tracking-wide">{{ config('app.name', 'Artist Atelier') }}</span>
                    <span class="mt-1 block text-xs text-blue-100">Art, thoughtfully found</span>
                </span>
            </a>

            <div class="hidden items-center gap-0 lg:flex">
                @foreach ($navLinks as $link)
                    <a
                        href="{{ route($link['route']) }}"
                        @if (request()->routeIs($link['active'])) aria-current="page" @endif
                        @class([
                            'rounded-xl px-3 py-2.5 text-sm font-medium transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white',
                            'bg-white text-blue-800 shadow-sm' => request()->routeIs($link['active']),
                            'text-blue-50 hover:bg-white/15 hover:text-white' => ! request()->routeIs($link['active']),
                        ])
                    >{{ $link['label'] }}</a>
                @endforeach
            </div>

            <div class="hidden items-center gap-2 lg:flex">
                @auth
                    <a href="{{ route('profile.edit') }}" class="rounded-xl px-3 py-2 text-sm font-medium text-blue-50 transition hover:bg-white/15 hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-blue-800 shadow-sm transition hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-xl px-3 py-2 text-sm font-medium text-blue-50 transition hover:bg-white/15 hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">Log in</a>
                    <a href="{{ route('register') }}" class="rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-blue-800 shadow-sm transition hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">Join as an artist</a>
                @endauth
            </div>

            <details class="group relative lg:hidden">
                <summary class="flex h-11 w-11 cursor-pointer list-none items-center justify-center rounded-xl bg-white/15 transition hover:bg-white/25 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white [&::-webkit-details-marker]:hidden" aria-label="Toggle navigation menu">
                    <svg class="h-6 w-6 group-open:hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" />
                    </svg>
                    <svg class="hidden h-6 w-6 group-open:block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" d="m6 6 12 12M18 6 6 18" />
                    </svg>
                </summary>

                <div class="absolute right-0 top-14 z-50 w-72 max-w-[calc(100vw-2rem)] rounded-2xl border border-blue-100 bg-white p-3 text-slate-800 shadow-xl">
                    <div class="space-y-1">
                        @foreach ($navLinks as $link)
                            <a
                                href="{{ route($link['route']) }}"
                                @if (request()->routeIs($link['active'])) aria-current="page" @endif
                                @class([
                                    'block rounded-xl px-4 py-3 text-sm font-medium transition',
                                    'bg-blue-50 text-blue-800' => request()->routeIs($link['active']),
                                    'text-slate-700 hover:bg-slate-50 hover:text-blue-800' => ! request()->routeIs($link['active']),
                                ])
                            >{{ $link['label'] }}</a>
                        @endforeach
                    </div>

                    <div class="mt-3 border-t border-slate-100 pt-3">
                        @auth
                            <a href="{{ route('profile.edit') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50 hover:text-blue-800">Profile</a>
                            <form method="POST" action="{{ route('logout') }}" class="px-2 pt-2">
                                @csrf
                                <button type="submit" class="w-full rounded-xl bg-blue-700 px-4 py-3 text-left text-sm font-semibold text-white transition hover:bg-blue-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50 hover:text-blue-800">Log in</a>
                            <a href="{{ route('register') }}" class="mt-1 block rounded-xl bg-blue-700 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-800">Join as an artist</a>
                        @endauth
                    </div>
                </div>
            </details>
        </div>
    </nav>
</header>
