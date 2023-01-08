<?php

namespace App\Http\Controllers;
use App\Interfaces\ProductHistoryRepositoryInterface;
use App\Repositories\ProductHistoryRepository;


class ProductHistoryController extends Controller
{
    private ProductHistoryRepositoryInterface $productHistoryRepository;
    public function __construct()
    {
        $this->productHistoryRepository = new ProductHistoryRepository();
    }
    public function index()
    {
        // $productHistories = ProductHistory::query('product_histories')
        // ->join('users', 'users.id', '=', 'product_histories.user_id')
        // ->select('product_histories.*', 'users.name as userName')->get();
        $productHistories = $this->productHistoryRepository->getALlProductHistories();
        return view('product_histories.index', ['productHistories' => $productHistories]);
    }
    public function destroy($id)
    {

        $this->productHistoryRepository->deleteProductHistory($id);
        // DB::table('product_histories')->where('id', $id)->delete();
        return back()->with('message', 'Deleted successfully');
    }
}
