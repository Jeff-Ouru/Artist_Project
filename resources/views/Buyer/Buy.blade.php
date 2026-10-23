<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-screen flex-col font-sans antialiased">
        <div class="flex-1 bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')
            <div class="border-b border-gray-200 bg-white/80 dark:border-gray-700 dark:bg-gray-800/80">
                <div class="mx-auto flex max-w-7xl justify-end px-4 py-2 sm:px-6 lg:px-8">
                    <x-current-date-time />
                </div>
            </div>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="bright-theme dark:dark-theme min-h-screen flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8">
                {{ $slot ?? '' }}
                @yield('content')
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                  {{=======Header content goes here======= }}
                  <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                      <p = class="text-gray-600 dark:text-gray-400">Welcome to the Buyer Dashboard. Here you can browse and purchase artworks from various artists.</p>
                      <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Featured Artworks</h1>
                      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                        @foreach($featuredArtworks as $artwork)
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                                <img src="{{ $artwork->image_url }}" alt="{{ $artwork->title }}" class="w-full h-48 object-cover">
                                <div class="p-4">
                                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $artwork->title }}</h2>
                                    <p class="text-gray-600 dark:text-gray-400">{{ $artwork->artist->name }}</p>
                                    <p class="text-gray-800 dark:text-gray-200">${{ number_format($artwork->price, 2) }}</p>
                                    <a href="{{ route('artworks.show', $artwork) }}" class="mt-2 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">View Details</a>
                                </div>
                            </div>
                        @endforeach
                  
                  </div>

                </div>
            </main>

            <x-footer />

        </div>
    </body>