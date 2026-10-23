<x-app-layout>
    <main class="bright-theme min-h-screen bg-slate-100 px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-2xl">
            <div class="mb-6">
                <a href="{{ route('seller.artworks.index') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">← Back to my listings</a>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-slate-900">Edit artwork</h1>
                <p class="mt-2 text-slate-600">Update the details collectors see on your listing.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-xl bg-red-50 p-4 text-sm text-red-700">
                    <ul class="list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('seller.artworks.update', $artwork) }}" enctype="multipart/form-data" class="space-y-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700">Artwork title</label>
                    <input id="title" name="title" value="{{ old('title', $artwork->title) }}" required class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-slate-900 focus:ring-slate-900">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700">Description</label>
                    <textarea id="description" name="description" rows="5" required class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-slate-900 focus:ring-slate-900">{{ old('description', $artwork->description) }}</textarea>
                </div>

                @if ($artwork->images->isNotEmpty())
                    <div>
                        <p class="block text-sm font-medium text-slate-700">Current photos</p>
                        <div class="mt-2 grid grid-cols-3 gap-3">
                            @foreach ($artwork->images as $image)
                                <img src="{{ $image->url }}" alt="{{ $image->alt_text ?? $artwork->title }}" class="aspect-square w-full rounded-lg object-cover">
                            @endforeach
                        </div>
                        <label class="mt-3 inline-flex items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" name="remove_images" value="1" @checked(old('remove_images')) class="rounded border-slate-300">
                            Remove current uploaded photos
                        </label>
                    </div>
                @endif

                <div>
                    <label for="images" class="block text-sm font-medium text-slate-700">Replace photos <span class="font-normal text-slate-400">(optional, up to 5 JPG/PNG/WebP files, 5 MB each)</span></label>
                    <input id="images" type="file" name="images[]" accept="image/jpeg,image/png,image/webp" multiple class="mt-1 block w-full rounded-xl border border-slate-300 bg-white p-2 text-sm text-slate-700 file:me-4 file:rounded-lg file:border-0 file:bg-violet-100 file:px-3 file:py-2 file:font-semibold file:text-violet-700 hover:file:bg-violet-200 focus:border-slate-900 focus:ring-slate-900">
                    <p class="mt-1 text-xs text-slate-500">Uploading new photos replaces the current uploaded photos.</p>
                    @error('images')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    @error('images.*')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="image_url" class="block text-sm font-medium text-slate-700">Image URL <span class="font-normal text-slate-400">(optional)</span></label>
                    <input id="image_url" type="url" name="image_url" value="{{ old('image_url', $artwork->images->isNotEmpty() ? '' : $artwork->image_url) }}" placeholder="https://..." class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-slate-900 focus:ring-slate-900">
                    @error('image_url')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="price" class="block text-sm font-medium text-slate-700">Price</label>
                        <input id="price" type="number" min="0" step="0.01" name="price" value="{{ old('price', $artwork->price) }}" required class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-slate-900 focus:ring-slate-900">
                    </div>
                    <div>
                        <label for="currency" class="block text-sm font-medium text-slate-700">Currency</label>
                        <input id="currency" name="currency" value="{{ old('currency', $artwork->currency) }}" maxlength="3" required class="mt-1 block w-full rounded-xl border-slate-300 uppercase shadow-sm focus:border-slate-900 focus:ring-slate-900">
                    </div>
                </div>

                <button type="submit" class="w-full rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-700">Save changes</button>
            </form>
        </div>
    </main>
</x-app-layout>
