<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class City extends Model
{
    use HasFactory;



    protected $fillable = [
        'ar_name',
        'en_name',
        'ar_slug',
        'en_slug',
        'country_id',
        'zone_id'
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

    public function country() : BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function zone() : BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

}
