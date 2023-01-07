<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use App\Models\ProductHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAllProducts()
    {
        return Product::query('products')
            ->join('product_types', 'products.product_type_id', '=', 'product_types.id')
            ->select('products.*', 'product_types.name as productType')->get();
    }
    public function getAllProductTypes()
    {
        return DB::table('product_types')->get();
    }

    public function addProducts(array $formFields)
    {
        $formFields['created_at'] = Carbon::now();
        $formFields['updated_at'] = Carbon::now();
        $productId = DB::table('products')->insertGetId($formFields);
        return $productId;
    }

    public function addProductHistory($productHistory)
    {
        $productHistory['created_at'] = Carbon::now();
        $productHistory['updated_at'] = Carbon::now();
        DB::table('product_histories')->insert($productHistory);
    }

    public function getProductTypeNameById($productType)
    {
        return DB::table('product_types')->select('name')->where('id', '=', $productType)->first();
    }

    public function getProductsByUserId($userId)
    {
        return Product::query('products')
            ->join('product_types', 'products.product_type_id', '=', 'product_types.id')
            ->select('products.*', 'product_types.name as productType')
            ->where('user_id', '=', $userId)
            ->filter(request(['product_search']))->paginate(8);
    }

    public function getProductByProductId($productId)
    {
        return DB::table('products')->where('id', '=', $productId)->first();
    }

    public function updateProduct($productId, $formFields)
    {
        DB::table('products')
            ->where('id', $productId)
            ->update([
                'price' => $formFields['price'],
                'description' => $formFields['description'],
                'updated_at' => Carbon::now()
            ]);

        if (count($formFields) == 3) {
            DB::table('products')
                ->where('id', $productId)
                ->update([
                    'image' => $formFields['image'],
                    'updated_at' => Carbon::now()
                ]);
        }
    }
    public function deleteProduct($productId)
    {
        DB::table('products')->where('id', $productId)->delete();
    }
}
