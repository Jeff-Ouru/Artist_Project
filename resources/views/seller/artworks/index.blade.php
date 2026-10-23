<x-app-layout>
    <main class="bright-theme min-h-screen bg-slate-100 px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-6xl">
            <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-700">Seller studio</p>
                    <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">My artwork listings</h1>
                    <p class="mt-2 text-slate-600">Every buyer inquiry is saved here and sent to your notifications.</p>
                </div>
                <a href="{{ route('seller.artworks.create') }}" class="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-700">List an artwork</a>
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-xl bg-emerald-50 p-4 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
            @endif

            <div id="certificates" class="space-y-4">
                @forelse ($artworks as $artwork)
                    <div class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <div class="flex items-center gap-3">
                                <h2 class="text-xl font-semibold text-slate-900">{{ $artwork->title }}</h2>
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $artwork->status === 'available' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }}">{{ ucfirst($artwork->status) }}</span>
                            </div>
                            <p class="mt-2 text-sm text-slate-500">{{ $artwork->currency }} {{ number_format((float) $artwork->price, 2) }} • {{ $artwork->inquiries_count }} buyer {{ $artwork->inquiries_count === 1 ? 'inquiry' : 'inquiries' }}</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-3">
                            <a href="{{ route('seller.artworks.certificate', $artwork) }}" class="text-sm font-semibold text-amber-700 hover:text-amber-900">Issue COA</a>
                            <a href="{{ route('seller.artworks.edit', $artwork) }}" class="text-sm font-semibold text-slate-700 hover:text-slate-900">Edit</a>
                            <a href="{{ route('artworks.show', $artwork) }}" class="text-sm font-semibold text-slate-700 hover:text-slate-900">View listing</a>
                            <form method="POST" action="{{ route('seller.artworks.status', $artwork) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="{{ $artwork->status === 'available' ? 'sold' : 'available' }}">
                                <button type="submit" class="rounded-xl border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Mark {{ $artwork->status === 'available' ? 'sold' : 'available' }}</button>
                            </form>
                            <form method="POST" action="{{ route('seller.artworks.destroy', $artwork) }}" onsubmit="return confirm('Delete this artwork permanently?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-xl border border-red-200 px-3 py-2 text-sm font-semibold text-red-700 hover:bg-red-50">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center shadow-sm">
                        <h2 class="text-xl font-semibold text-slate-900">You have no listings yet</h2>
                        <p class="mt-2 text-slate-500">Publish your first artwork to start receiving buyer inquiries.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</x-app-layout>
