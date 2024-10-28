<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryBrand extends Model
{
    use HasFactory;

    protected $table = 'category_brands';
    protected $fillable = ['category_id', 'brand_id'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }
}
