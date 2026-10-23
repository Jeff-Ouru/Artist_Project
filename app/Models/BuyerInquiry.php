<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuyerInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'artwork_id',
        'seller_id',
        'buyer_name',
        'buyer_email',
        'message',
    ];

    protected $casts = [
        'read_at' => 'datetime',
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
