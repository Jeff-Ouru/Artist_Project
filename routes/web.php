<?php

use App\Http\Controllers\ArtworkController;
use App\Http\Controllers\BuyerInquiryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerArtworkController;
use App\Http\Controllers\InquiryController;
use App\Models\Artwork;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', [
        'artworks' => Artwork::with(['seller', 'images'])->latest()->take(4)->get(),
    ]);
})->name('home');
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/dashboard', function () {
    return redirect()->route('login');
})
    ->middleware('guest')
    ->name('dashboard.login');

Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/artworks', [ArtworkController::class, 'index'])->name('artworks.index');
Route::get('/artworks/{artwork}', [ArtworkController::class, 'show'])->name('artworks.show');
Route::post('/artworks/{artwork}/inquiries', [BuyerInquiryController::class, 'store'])->name('artworks.inquiries.store');
Route::post('/artworks/{artwork}/inquiries/inquiries', [BuyerInquiryController::class, 'store'])->name('artworks.inquiries.store');

Route::middleware('auth')->group(function () {
    Route::get('/seller/artworks', [SellerArtworkController::class, 'index'])->name('seller.artworks.index');
    Route::get('/seller/artworks/create', [SellerArtworkController::class, 'create'])->name('seller.artworks.create');
    Route::get('/seller/artworks/{artwork}/certificate', [SellerArtworkController::class, 'certificate'])->name('seller.artworks.certificate');
    Route::get('/seller/artworks/{artwork}/edit', [SellerArtworkController::class, 'edit'])->name('seller.artworks.edit');
    Route::post('/seller/artworks', [SellerArtworkController::class, 'store'])->name('seller.artworks.store');
    Route::put('/seller/artworks/{artwork}', [SellerArtworkController::class, 'update'])->name('seller.artworks.update');
    Route::delete('/seller/artworks/{artwork}', [SellerArtworkController::class, 'destroy'])->name('seller.artworks.destroy');
    Route::patch('/seller/artworks/{artwork}/status', [SellerArtworkController::class, 'updateStatus'])->name('seller.artworks.status');
    Route::patch('/inquiries/{inquiry}/archive', [InquiryController::class, 'archive'])->name('inquiries.archive')->middleware('auth');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
