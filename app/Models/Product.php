<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id', 'name', 'slug', 'sku', 'short_description',
        'description', 'specifications', 'price', 'price_type', 'image',
        'is_featured', 'is_published', 'created_by', 'updated_by',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (Product $p) {
            if (! $p->slug) {
                $p->slug = Str::slug($p->name);
            }
            if (! $p->sku) {
                $p->sku = 'PRD-' . strtoupper(Str::random(6));
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image && str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/placeholder-product.svg');
    }

    public function getFormattedPriceAttribute(): string
    {
        if ($this->price_type === 'contact') {
            return 'Hubungi Kami';
        }
        $symbol = \App\Support\Settings::currencySymbol();
        $amount = number_format((float) $this->price, 0, ',', '.');
        if ($this->price_type === 'starting_from') {
            return 'Mulai ' . $symbol . ' ' . $amount;
        }
        return $symbol . ' ' . $amount;
    }
}
