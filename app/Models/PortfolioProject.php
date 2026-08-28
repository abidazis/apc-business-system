<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PortfolioProject extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'customer_name', 'project_date', 'description',
        'cover_image', 'is_published', 'sort_order', 'created_by',
    ];

    protected $casts = [
        'project_date' => 'date',
        'is_published' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function images()
    {
        return $this->hasMany(PortfolioImage::class)->orderBy('sort_order');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'portfolio_project_product')
            ->withPivot('quantity');
    }

    public function getCoverImageUrlAttribute(): string
    {
        if ($this->cover_image && str_starts_with($this->cover_image, 'http')) {
            return $this->cover_image;
        }
        return $this->cover_image
            ? asset('storage/' . $this->cover_image)
            : asset('images/placeholder-portfolio.svg');
    }
}
