<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ArtworkImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'artwork_id',
        'path',
        'disk',
        'alt_text',
        'width',
        'height',
        'size_bytes',
        'is_primary',
        'sort_order',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'width'      => 'integer',
        'height'     => 'integer',
        'size_bytes' => 'integer',
    ];

    protected $appends = ['url'];

    public function artwork(): BelongsTo
    {
        return $this->belongsTo(Artwork::class);
    }

    /** Public URL for the stored file. */
    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    /** Thumbnail URL — assumes you generated one (see controller). */
    public function getThumbUrlAttribute(): string
    {
        $thumb = preg_replace('/(\.[a-z0-9]+)$/i', '_thumb$1', $this->path);
        return Storage::disk($this->disk)->url($thumb);
    }

    /** Delete the file when the row is deleted. */
    protected static function booted(): void
    {
        static::deleting(function (self $image) {
            Storage::disk($image->disk)->delete($image->path);

            $thumb = preg_replace('/(\.[a-z0-9]+)$/i', '_thumb$1', $image->path);
            Storage::disk($image->disk)->delete($thumb);
        });
    }
}