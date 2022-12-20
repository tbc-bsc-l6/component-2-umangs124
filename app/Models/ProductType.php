<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;
    // Relationship to Product
    public function products()
    {
        return $this->HasMany(Product::class, 'product_type_id');
    }
}
