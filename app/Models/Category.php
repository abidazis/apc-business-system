<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean', 'sort_order' => 'integer'];

    protected static function booted(): void
    {
        static::saving(function (Category $c) {
            if (! $c->slug) {
                $c->slug = Str::slug($c->name);
            }
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
