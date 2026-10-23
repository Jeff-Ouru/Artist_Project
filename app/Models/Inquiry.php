<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inquiry extends Model
{
    protected $fillable = [
        'artwork_id',
        'seller_id',
        'buyer_name',
        'buyer_email',
        'message',
        'attach_dossier',
        'status',
    ];

    protected $casts = [
        'attach_dossier' => 'boolean',
    ];

    public function artwork(): BelongsTo
    {
        return $this->belongsTo(Artwork::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}