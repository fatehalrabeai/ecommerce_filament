<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;



    protected $fillable = [
        'name',
        'brief',
        'content',
        'description',
        'expiry_date',
        'avg_rating',
        'total_ratings',
        'sku',
        'slug',
        'status',
        'category_id',
        'brand_id',
    ];

    public static function booted(): void
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    public function images(){
        return $this->hasMany(ProductImage::class);
    }
    public function suppliers(){
        return $this->belongsToMany(Supplier::class);
    }
}
