<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => OrderStatus::class,
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
    protected $fillable = ['user_id', 'total_price', 'status', 'ordered_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderProduct::class);
    }

//    public function payment()
//    {
//        return $this->hasOne(Payment::class);
//    }
//
//    public function shipping()
//    {
//        return $this->hasOne(Shipping::class);
//    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'order_coupons');
    }

    public function statusHistory()
    {
        return $this->hasMany(OrderStatusHistory::class);
    }
}
