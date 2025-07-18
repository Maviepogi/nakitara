<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    protected $fillable = [
        'title',
        'description',
        'type',
        'location',
        'latitude',
        'longitude',
        'images',
        'status',
        'user_id',
        'category_id'
    ];

    protected $casts = [
        'images' => 'array', // This handles JSON conversion automatically
    ];

    // Accessor for backward compatibility - get first image
    public function getImageAttribute()
    {
        return $this->images && count($this->images) > 0 ? $this->images[0] : null;
    }

    // Remove the conflicting getImagesAttribute method
    // The 'images' => 'array' cast handles this automatically

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}