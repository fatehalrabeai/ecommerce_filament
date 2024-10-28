<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Filament\Panel;

class User extends Authenticatable
//    implements FilamentUser
{
    use HasFactory, Notifiable;



    public static function booted(): void
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

//    public function canAccessPanel(Panel $panel): bool
//    {
//        return str_ends_with($this->email, 'fateh') && $this->hasVerifiedEmail();
//    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function country() : BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function city() : BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function district() : BelongsTo
    {
        return $this->belongsTo(District::class);
    }
}
