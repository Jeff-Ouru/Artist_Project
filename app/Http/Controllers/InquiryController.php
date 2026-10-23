<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InquiryReceived;

class InquiryController extends Controller
{
    public function store(Request $request, Artwork $artwork)
    {
        $data = $request->validate([
            'buyer_name'     => ['required', 'string', 'max:120'],
            'buyer_email'    => ['required', 'email', 'max:180'],
            'message'        => ['required', 'string', 'max:5000'],
            'attach_dossier' => ['nullable', 'boolean'],
        ]);

        $inquiry = Inquiry::create([
            'artwork_id'   => $artwork->id,
            'seller_id'    => $artwork->seller_id,
            'buyer_name'   => $data['buyer_name'],
            'buyer_email'  => $data['buyer_email'],
            'message'      => $data['message'],
            'attach_dossier' => (bool) ($data['attach_dossier'] ?? false),
            'status'       => 'new',
        ]);

        // Notify the seller
        Mail::to($artwork->seller->email)->send(new InquiryReceived($inquiry));

        return back()->with('success', 'Your inquiry has been sent to the artist.');
    }

    public function archive(Inquiry $inquiry)
    {
        $this->authorize('update', $inquiry);   // or check ownership

        $inquiry->update(['status' => 'archived']);

        return back()->with('success', 'Inquiry archived.');
    }
}