<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isFarmer(): bool
    {
        return $this->role === 'farmer';
    }

    public function isSupplier(): bool
    {
        return $this->role === 'supplier';
    }

    public function isBuyer(): bool
    {
        return $this->role === 'buyer';
    }

    public function isSeller(): bool
    {
        return in_array($this->role, ['farmer', 'supplier']);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function farmerProfile(): HasOne
    {
        return $this->hasOne(FarmerProfile::class);
    }

    public function supplierProfile(): HasOne
    {
        return $this->hasOne(SupplierProfile::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    /**
     * A generated avatar (initials on a colored background) so every
     * account has a picture without needing real uploaded photos.
     */
    public function getAvatarUrlAttribute(): string
    {
        $colors = [
            'admin' => '2e7d32',
            'farmer' => '6d4c1e',
            'supplier' => '1565c0',
            'buyer' => 'ef6c00',
        ];

        $bg = $colors[$this->role] ?? '2e7d32';

        return 'https://ui-avatars.com/api/?name='.urlencode($this->name)
            .'&background='.$bg.'&color=fff&bold=true&size=128';
    }
}
