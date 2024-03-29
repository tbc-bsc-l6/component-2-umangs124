<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'verification_token',
        'password',
        'image',
        'role_id'
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

    public function scopeFilter($query)
    {
        if (request('user_search') ?? false) {
            $query->where('name', 'like', '%' . request('user_search') . '%');
        }
    }
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // Relationship to Product
    public function products()
    {
        return $this->HasMany(Product::class, 'user_id');
    }

    // Relationship to ProductHistory
    public function productHistories()
    {
        return $this->hasMany(ProductHistory::class, 'user_id');
    }

    // Relationship to Role
    public function role()
    {
        return $this->belongsTo(User::class, 'role_id');
    }
}
