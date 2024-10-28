<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;



    public static function booted(): void
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    protected $fillable = ['name', 'parent_id', 'slug', 'status'];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Scope to get categories by status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope to get only active categories
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'category_brands')->withTimestamps();
    }

}
