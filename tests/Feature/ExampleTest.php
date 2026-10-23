<?php

it('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

it('renders the about page', function () {
    $this->get('/about')
        ->assertOk()
        ->assertSee('Main navigation')
        ->assertSee('Browse art')
        ->assertSee('Our Story')
        ->assertSee('<title>About — Artist Atelier</title>', false);
});

it('renders the shared navigation on the homepage and artwork listing', function () {
    foreach ([route('home'), route('artworks.index')] as $url) {
        $this->get($url)
            ->assertOk()
            ->assertSee('Main navigation')
            ->assertSee('Browse art')
            ->assertSee('About');
    }
});

it('shows a working registration link on the homepage for guests', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee(route('register'))
        ->assertSee('Join as an artist')
        ->assertSee(route('login'))
        ->assertSee('Find art that feels like it belongs to you.')
        ->assertDontSee('Oct 24, 2024');
});

it('renders the homepage for authenticated users', function () {
    $user = \App\Models\User::factory()->create();

    $this->actingAs($user)
        ->get('/')
        ->assertOk()
        ->assertSee('Browse artworks')
        ->assertSee('Profile')
        ->assertSee('Log Out')
        ->assertSee(route('artworks.index'));
});

it('renders the footer on application and guest pages', function () {
    foreach ([route('home'), route('artworks.index'), route('login')] as $url) {
        $this->get($url)
            ->assertOk()
            ->assertSee('data-live-clock', false)
            ->assertSee('data-live-date', false)
            ->assertSee('data-live-time', false)
            ->assertSee('<footer', false)
            ->assertSee('All rights reserved.');
    }
});
