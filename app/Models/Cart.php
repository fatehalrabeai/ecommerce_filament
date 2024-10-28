<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cart extends Model
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


    protected $fillable = ['user_id', 'session_id'];

    public function items()
    {
        return $this->hasMany(CartProduct::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
