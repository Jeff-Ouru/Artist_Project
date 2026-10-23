<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Artwork extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'title',
        'description',
        'image_url',
        'exhibition_date',
        'price',
        'currency',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(BuyerInquiry::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ArtworkImage::class)->orderBy('sort_order')->orderBy('id');
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }
}
