<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;



    protected $fillable = ['name', 'slug', 'image_name'];

    public static function booted(): void
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    // Many-to-many relationship with Category
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_brands')->withTimestamps();
    }

    public function products()
    {
        return $this->HasMany(Product::class);
    }
}
