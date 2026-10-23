<x-app-layout>
    <main class="bright-theme min-h-screen bg-slate-100 px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-2xl">
            <div class="mb-6">
                <a href="{{ route('seller.artworks.index') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">← Back to my listings</a>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-slate-900">List an artwork for sale</h1>
                <p class="mt-2 text-slate-600">Add the details buyers need before contacting you.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-xl bg-red-50 p-4 text-sm text-red-700"><ul class="list-inside list-disc space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif

            <form method="POST" action="{{ route('seller.artworks.store') }}" enctype="multipart/form-data" class="space-y-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                @csrf
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700">Artwork title</label>
                    <input id="title" name="title" value="{{ old('title') }}" required class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-slate-900 focus:ring-slate-900">
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700">Description</label>
                    <textarea id="description" name="description" rows="5" required class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-slate-900 focus:ring-slate-900">{{ old('description') }}</textarea>
                </div>
                <div>
                    <label for="images" class="block text-sm font-medium text-slate-700">Artwork photos <span class="font-normal text-slate-400">(up to 5, JPG/PNG/WebP, 5 MB each)</span></label>
                    <input id="images" type="file" name="images[]" accept="image/jpeg,image/png,image/webp" multiple class="mt-1 block w-full rounded-xl border border-slate-300 bg-white p-2 text-sm text-slate-700 shadow-sm file:me-4 file:rounded-lg file:border-0 file:bg-violet-100 file:px-3 file:py-2 file:font-semibold file:text-violet-700 hover:file:bg-violet-200 focus:border-slate-900 focus:ring-slate-900">
                    @error('images')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    @error('images.*')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    <p class="mt-1 text-xs text-slate-500">Photos are stored securely and shown on the public artwork page.</p>
                </div>
                <div>
                    <label for="image_url" class="block text-sm font-medium text-slate-700">Or use an image URL <span class="font-normal text-slate-400">(optional)</span></label>
                    <input id="image_url" type="url" name="image_url" value="{{ old('image_url') }}" placeholder="https://..." class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-slate-900 focus:ring-slate-900">
                    @error('image_url')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="price" class="block text-sm font-medium text-slate-700">Price</label>
                        <input id="price" type="number" min="0" step="0.01" name="price" value="{{ old('price') }}" required class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-slate-900 focus:ring-slate-900">
                    </div>
                    <div>
                        <label for="currency" class="block text-sm font-medium text-slate-700">Currency</label>
                        <input id="currency" name="currency" value="{{ old('currency', 'KES') }}" maxlength="3" required class="mt-1 block w-full rounded-xl border-slate-300 uppercase shadow-sm focus:border-slate-900 focus:ring-slate-900">
                    </div>
                </div>
                <button class="w-full rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-700">Publish artwork</button>
            </form>
        </div>
    </main>
</x-app-layout>
