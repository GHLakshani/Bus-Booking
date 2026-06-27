<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
        'telephone', 'province', 'district', 'address', 'postal_code', 'user_type',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return ['password' => 'hashed', 'reset_token_expiry' => 'datetime'];
    }

    public function isAdmin(): bool
    {
        return $this->user_type === 'admin';
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
