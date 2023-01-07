<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'image',
        'description',
        'product_type_id',
        'user_id'
    ];
    
    public function scopeFilter($query)
    {
        if (request('product_search') ?? false) {
            $query->where('products.name', 'like', '%' . request('product_search') . '%');
        }
    }
    // Relationship to User
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship to ProductType
    public function productType() {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }

}
