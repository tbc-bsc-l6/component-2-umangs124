<?php

namespace App\Repositories;

use App\Interfaces\ProductHistoryRepositoryInterface;
use App\Models\ProductHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductHistoryRepository implements ProductHistoryRepositoryInterface
{
    public function addProductHistory($productHistory)
    {
        $productHistory['created_at'] = Carbon::now();
        $productHistory['updated_at'] = Carbon::now();
        DB::table('product_histories')->insert($productHistory);
    }
    public function getAllProductHistories()
    {
        return ProductHistory::query('product_histories')
        ->join('users', 'users.id', '=', 'product_histories.user_id')
        ->select('product_histories.*', 'users.name as userName')->latest()->get();
    }
    public function deleteProductHistory($id)
    {
        DB::table('product_histories')->where('id', $id)->delete();
    }
}
