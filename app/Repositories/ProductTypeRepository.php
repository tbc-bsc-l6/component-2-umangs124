<?php

namespace App\Repositories;

use App\Interfaces\ProductTypeRepositoryInterface;
use App\Models\ProductType;
use Illuminate\Support\Facades\DB;

class ProductTypeRepository implements ProductTypeRepositoryInterface
{
    public function addProductTypes($productType)
    {
        ProductType::create($productType);
    }
    public function getAllProductTypes()
    {
        return ProductType::all();
    }
    public function deleteProductTypes($id)
    {
        DB::table('product_types')->where('id', $id)->delete();
    }
}