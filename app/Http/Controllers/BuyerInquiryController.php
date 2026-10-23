<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\BuyerInquiry;
use App\Notifications\BuyerInquiryReceived;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BuyerInquiryController extends Controller
{
    public function store(Request $request, Artwork $artwork): RedirectResponse
    {
        abort_unless($artwork->isAvailable(), 404);

        $validated = $request->validate([
            'buyer_name' => ['required', 'string', 'max:120'],
            'buyer_email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $inquiry = BuyerInquiry::create([
            ...$validated,
            'artwork_id' => $artwork->id,
            'seller_id' => $artwork->seller_id,
        ]);

        $artwork->seller->notify(new BuyerInquiryReceived($inquiry->load('artwork')));

        return back()->with('success', 'Your inquiry has been sent to the seller.');
    }
}
