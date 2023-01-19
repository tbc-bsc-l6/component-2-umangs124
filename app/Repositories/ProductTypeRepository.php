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
        return ProductType::latest()->get();
    }
    public function deleteProductTypes($id)
    {
        DB::table('product_types')->where('id', $id)->delete();
    }
    public function getProductTypeNameById($productType)
    {
        return DB::table('product_types')->select('name')->where('id', '=', $productType)->first();
    }
}
