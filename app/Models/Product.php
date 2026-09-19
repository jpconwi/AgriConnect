<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'name', 'description',
        'price', 'unit', 'stock_quantity', 'image', 'status',
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Resolve a usable image URL whether the product has a locally
     * uploaded file (stored on the public disk) or an external URL
     * (e.g. from seeded/demo data).
     */
    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        return asset('storage/'.$this->image);
    }

    /**
     * A deterministic, thematically-relevant placeholder image so
     * empty-state "No image" boxes are never shown for demo data.
     */
    public function getDisplayImageAttribute(): string
    {
        return $this->image_url ?? 'https://loremflickr.com/640/480/agriculture,farm?lock='.$this->id;
    }
}
