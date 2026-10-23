<?php

use App\Models\Artwork;
use App\Models\User;
use App\Notifications\BuyerInquiryReceived;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('a visitor can view available and sold artwork listings', function () {
    $seller = User::factory()->create();
    $availableArtwork = Artwork::create([
        'seller_id' => $seller->id,
        'title' => 'Blue Horizon',
        'description' => 'Original oil painting.',
        'price' => 25000,
        'currency' => 'KES',
    ]);
    $soldArtwork = Artwork::create([
        'seller_id' => $seller->id,
        'title' => 'Evening Light',
        'description' => 'A sold landscape painting.',
        'price' => 18000,
        'currency' => 'KES',
        'status' => 'sold',
    ]);

    $this->get(route('artworks.index'))
        ->assertOk()
        ->assertSee($availableArtwork->title)
        ->assertSee($soldArtwork->title)
        ->assertSee('Sold');
});

test('a visitor can search filter and sort the artwork collection', function () {
    $seller = User::factory()->create(['name' => 'Studio Artist']);
    $amberArtwork = Artwork::create([
        'seller_id' => $seller->id,
        'title' => 'Amber Field',
        'description' => 'A warm abstract landscape.',
        'price' => 40000,
        'currency' => 'KES',
    ]);
    $blueArtwork = Artwork::create([
        'seller_id' => $seller->id,
        'title' => 'Blue Horizon',
        'description' => 'An ocean view in blue.',
        'price' => 10000,
        'currency' => 'KES',
    ]);
    $soldArtwork = Artwork::create([
        'seller_id' => $seller->id,
        'title' => 'Evening Light',
        'description' => 'A sold landscape painting.',
        'price' => 20000,
        'currency' => 'KES',
        'status' => 'sold',
    ]);

    $this->get(route('artworks.index', ['q' => 'Studio Artist']))
        ->assertOk()
        ->assertSee($amberArtwork->title)
        ->assertSee($blueArtwork->title)
        ->assertSee($soldArtwork->title);

    $this->get(route('artworks.index', ['q' => 'ocean', 'status' => 'available']))
        ->assertOk()
        ->assertSee($blueArtwork->title)
        ->assertDontSee($amberArtwork->title)
        ->assertDontSee($soldArtwork->title);

    $content = $this->get(route('artworks.index', ['status' => 'available', 'sort' => 'price_asc']))
        ->assertOk()
        ->assertSee('value="price_asc" selected', false)
        ->getContent();

    expect(strpos($content, $blueArtwork->title))
        ->toBeLessThan(strpos($content, $amberArtwork->title));
});

test('a visitor can view artwork details and submit the inquiry form', function () {
    $seller = User::factory()->create(['name' => 'Jordan Seller']);
    $artwork = Artwork::create([
        'seller_id' => $seller->id,
        'title' => 'Blue Horizon',
        'description' => 'Original oil painting.',
        'price' => 25000,
        'currency' => 'KES',
    ]);

    $this->get(route('artworks.show', $artwork))
        ->assertOk()
        ->assertSee($artwork->title)
        ->assertSee('shrink-0 items-center justify-center rounded-full', false)
        ->assertSee('>J', false)
        ->assertSee('Contact seller about this artwork');
});

test('a visitor can view sold artwork without an inquiry form', function () {
    $seller = User::factory()->create();
    $artwork = Artwork::create([
        'seller_id' => $seller->id,
        'title' => 'Evening Light',
        'description' => 'A sold landscape painting.',
        'price' => 18000,
        'currency' => 'KES',
        'status' => 'sold',
    ]);

    $this->get(route('artworks.show', $artwork))
        ->assertOk()
        ->assertSee($artwork->title)
        ->assertSee('This artwork has been sold.')
        ->assertDontSee('Contact seller about this artwork');
});

test('a seller can view their artwork listings', function () {
    $seller = User::factory()->create();
    $artwork = Artwork::create([
        'seller_id' => $seller->id,
        'title' => 'Blue Horizon',
        'description' => 'Original oil painting.',
        'price' => 25000,
        'currency' => 'KES',
    ]);

    $this->actingAs($seller)
        ->get(route('seller.artworks.index'))
        ->assertOk()
        ->assertSee($artwork->title)
        ->assertSee(route('seller.artworks.certificate', $artwork))
        ->assertSee(route('seller.artworks.edit', $artwork))
        ->assertSee(route('seller.artworks.destroy', $artwork));
});

test('a seller can edit their artwork but cannot edit another sellers artwork', function () {
    $seller = User::factory()->create();
    $otherSeller = User::factory()->create();
    $artwork = Artwork::create([
        'seller_id' => $seller->id,
        'title' => 'Blue Horizon',
        'description' => 'Original oil painting.',
        'price' => 25000,
        'currency' => 'KES',
    ]);

    $this->actingAs($seller)
        ->get(route('seller.artworks.edit', $artwork))
        ->assertOk()
        ->assertSee('Edit artwork');

    $this->actingAs($seller)
        ->put(route('seller.artworks.update', $artwork), [
            'title' => 'Blue Horizon Revised',
            'description' => 'Updated oil painting details.',
            'price' => 32000,
            'currency' => 'USD',
            'image_url' => null,
        ])
        ->assertRedirect(route('seller.artworks.index'));

    $this->assertDatabaseHas('artworks', [
        'id' => $artwork->id,
        'seller_id' => $seller->id,
        'title' => 'Blue Horizon Revised',
        'price' => '32000.00',
        'currency' => 'USD',
    ]);

    $this->actingAs($otherSeller)
        ->get(route('seller.artworks.edit', $artwork))
        ->assertForbidden();

    $this->actingAs($otherSeller)
        ->put(route('seller.artworks.update', $artwork), [
            'title' => 'Stolen update',
            'description' => 'Not allowed.',
            'price' => 1,
            'currency' => 'USD',
        ])
        ->assertForbidden();

    $this->actingAs($otherSeller)
        ->delete(route('seller.artworks.destroy', $artwork))
        ->assertForbidden();
});

test('a seller can change artwork status and other sellers cannot', function () {
    $seller = User::factory()->create();
    $otherSeller = User::factory()->create();
    $artwork = Artwork::create([
        'seller_id' => $seller->id,
        'title' => 'Blue Horizon',
        'description' => 'Original oil painting.',
        'price' => 25000,
        'currency' => 'KES',
    ]);

    $this->actingAs($seller)
        ->patch(route('seller.artworks.status', $artwork), ['status' => 'sold'])
        ->assertRedirect();

    $this->assertDatabaseHas('artworks', ['id' => $artwork->id, 'status' => 'sold']);

    $this->actingAs($otherSeller)
        ->patch(route('seller.artworks.status', $artwork), ['status' => 'available'])
        ->assertForbidden();
});

test('deleting an artwork removes its uploaded image files', function () {
    Storage::fake('public');
    $seller = User::factory()->create();
    $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/l1sAAAAASUVORK5CYII=');

    $this->actingAs($seller)->post(route('seller.artworks.store'), [
        'title' => 'Delete Test Artwork',
        'description' => 'Artwork used to verify cleanup.',
        'price' => '1000.00',
        'currency' => 'KES',
        'images' => [UploadedFile::fake()->createWithContent('delete-test.png', $png)],
    ])->assertRedirect(route('seller.artworks.index'));

    $artwork = Artwork::where('title', 'Delete Test Artwork')->firstOrFail();
    $image = $artwork->images()->firstOrFail();

    $this->actingAs($seller)
        ->delete(route('seller.artworks.destroy', $artwork))
        ->assertRedirect(route('seller.artworks.index'));

    $this->assertDatabaseMissing('artworks', ['id' => $artwork->id]);
    $this->assertDatabaseMissing('artwork_images', ['id' => $image->id]);
    Storage::disk('public')->assertMissing($image->path);
});

test('artwork management buttons are shown only to the listing owner', function () {
    $seller = User::factory()->create();
    $otherSeller = User::factory()->create();
    $artwork = Artwork::create([
        'seller_id' => $seller->id,
        'title' => 'Blue Horizon',
        'description' => 'Original oil painting.',
        'price' => 25000,
        'currency' => 'KES',
    ]);

    $this->actingAs($seller)
        ->get(route('artworks.index'))
        ->assertOk()
        ->assertSee(route('seller.artworks.edit', $artwork))
        ->assertSee(route('seller.artworks.status', $artwork))
        ->assertSee(route('seller.artworks.destroy', $artwork));

    $this->actingAs($otherSeller)
        ->get(route('artworks.index'))
        ->assertOk()
        ->assertDontSee(route('seller.artworks.edit', $artwork))
        ->assertDontSee(route('seller.artworks.destroy', $artwork));
});

test('a seller can issue a printable certificate only for their own artwork', function () {
    $seller = User::factory()->create(['name' => 'Jordan Seller']);
    $artwork = Artwork::create([
        'seller_id' => $seller->id,
        'title' => 'Blue Horizon',
        'description' => 'Original oil painting.',
        'price' => 25000,
        'currency' => 'KES',
    ]);

    $this->actingAs($seller)
        ->get(route('seller.artworks.certificate', $artwork))
        ->assertOk()
        ->assertSee('Certificate of Authenticity')
        ->assertSee('COA-' . str_pad((string) $artwork->id, 6, '0', STR_PAD_LEFT))
        ->assertSee('Print / Save PDF');

    $otherSeller = User::factory()->create();

    $this->actingAs($otherSeller)
        ->get(route('seller.artworks.certificate', $artwork))
        ->assertForbidden();
});

test('a guest is redirected to login from seller listings', function () {
    $this->get(route('seller.artworks.index'))
        ->assertRedirect(route('login'));
});

test('a buyer inquiry is saved and notifies the seller', function () {
    Notification::fake();
    $seller = User::factory()->create();
    $artwork = Artwork::create([
        'seller_id' => $seller->id,
        'title' => 'Blue Horizon',
        'description' => 'Original oil painting.',
        'price' => 25000,
        'currency' => 'KES',
    ]);

    $response = $this->post(route('artworks.inquiries.store', $artwork), [
        'buyer_name' => 'Amina Buyer',
        'buyer_email' => 'amina@example.com',
        'message' => 'I would like to know if this is still available.',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('buyer_inquiries', [
        'artwork_id' => $artwork->id,
        'seller_id' => $seller->id,
        'buyer_email' => 'amina@example.com',
    ]);
    Notification::assertSentTo($seller, BuyerInquiryReceived::class);
});

test('an authenticated seller can publish an artwork', function () {
    $seller = User::factory()->create();

    $this->actingAs($seller)->post(route('seller.artworks.store'), [
        'title' => 'New Work',
        'description' => 'A new original work.',
        'price' => '18000.00',
        'currency' => 'KES',
    ])->assertRedirect(route('seller.artworks.index'));

    $this->assertDatabaseHas('artworks', [
        'seller_id' => $seller->id,
        'title' => 'New Work',
        'price' => '18000.00',
    ]);
});

test('a seller can upload artwork photos and buyers can view them', function () {
    Storage::fake('public');
    $seller = User::factory()->create();
    $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/l1sAAAAASUVORK5CYII=');

    $this->actingAs($seller)->post(route('seller.artworks.store'), [
        'title' => 'Color Study',
        'description' => 'A small original study.',
        'price' => '12000.00',
        'currency' => 'KES',
        'images' => [UploadedFile::fake()->createWithContent('color-study.png', $png)],
    ])->assertRedirect(route('seller.artworks.index'));

    $artwork = Artwork::where('title', 'Color Study')->firstOrFail();
    $image = $artwork->images()->firstOrFail();

    expect($image->is_primary)->toBeTrue();
    Storage::disk('public')->assertExists($image->path);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee($artwork->title)
        ->assertSee($image->url);

    $this->get(route('artworks.show', $artwork))
        ->assertOk()
        ->assertSee($image->url);
});
