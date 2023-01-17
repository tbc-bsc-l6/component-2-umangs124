<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductHistoryRepositoryInterface;
use App\Repositories\ProductHistoryRepository;
use Illuminate\Support\Facades\Cache;

class ProductHistoryController extends Controller
{
    private ProductHistoryRepositoryInterface $productHistoryRepository;
    public function __construct()
    {
        $this->productHistoryRepository = new ProductHistoryRepository();
    }
    public function index()
    {
        if (Cache::has('allProductHistories')) {
            $productHistories = Cache::get('allProductHistories');
            return view('product_histories.index', ['productHistories' => $productHistories]);
        }
        $productHistories = $this->productHistoryRepository->getALlProductHistories();
        Cache::put('allProductHistories', $productHistories, now()->addMinutes(10));
        return view('product_histories.index', ['productHistories' => $productHistories]);
    }
    public function destroy($id)
    {
        $this->productHistoryRepository->deleteProductHistory($id);
        Cache::forget('allProductHistories');
        return back()->with('message', 'Deleted successfully');
    }
}
