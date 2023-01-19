<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductHistoryRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\ProductTypeRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\ProductHistory;
use App\Models\Stock;
use App\Repositories\ProductRepository;
use App\Repositories\ProductHistoryRepository;
use App\Repositories\ProductTypeRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    private ProductRepositoryInterface $productRepository;
    private ProductHistoryRepositoryInterface $productHistoryRepository;
    private UserRepositoryInterface $userRepository;
    private ProductTypeRepositoryInterface $productTypeRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
        $this->productHistoryRepository = new ProductHistoryRepository();
        $this->userRepository = new UserRepository();
        $this->productTypeRepository = new ProductTypeRepository();
    }
    public function index()
    {
        if (Cache::has('allProducts')) {
            $products = Cache::get('allProducts');
        } else {
            $products = $this->productRepository->getAllProducts();
            Cache::put('allProducts', $products, now()->addMinutes(10));
        }
        if (Cache::has('allProductTypes')) {
            $productTypes = Cache::get('allProductTypes');
        } else {
            $productTypes = $this->productTypeRepository->getAllProductTypes();
            Cache::put('allProductTypes', $productTypes, now()->addMinutes(10));
        }
        return view('products.index', ['products' => $products, 'productTypes' => $productTypes]);
    }
    public function create()
    {

        $productTypes = $this->productRepository->getAllProductTypes();
        if (Cache::has('allStocks')) {
            $stocks = Cache::get('allStocks');
        } else {
            $stocks = Stock::all();
            Cache::put('allStocks', $stocks, now()->addMinutes(10));
        }
        return view('products.create', ['productTypes' => $productTypes, 'stocks' => $stocks]);
    }
    public function store(Request $request)
    {

        $formFields = $request->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric|between:0,99999999.999',
            'description' => 'required|min:8',
            'stock_id' => 'required',
            'product_type_id' => 'required'
        ]);
        if ($request->hasFile('image')) {
            $formFields['image'] = $request->file('image')->store('productImage', 'public');
        }
        $formFields['user_id'] = $request->userId;

        $productId = $this->productRepository->addProducts($formFields);

        $product = $this->productRepository->getProductByProductId($productId);
        $stock = Stock::where('id', '=', $request->stock_id)->first();

        $productTypeName = $this->productTypeRepository->getProductTypeNameById($request->product_type_id);
        $productHistory['product_name'] = $product->name;
        $productHistory['product_price'] = $product->price;
        $productHistory['product_type'] = $productTypeName->name;
        $productHistory['user_id'] = $request->userId;
        $productHistory['action'] = "Product Added";
        $productHistory['stock'] = $stock->name;
        $this->productHistoryRepository->addProductHistory($productHistory);

        Cache::forget('allProducts');
        Cache::forget('allProductHistories');
        return redirect('showProductByVendorId/' . Auth::user()?->id)->with('message', 'Product added successfully');
    }


    public function show($userId)
    {
        if (Auth::user()?->role_id == 2) {
            $products = $this->productRepository->getProductsByUserId($userId);
            $user = $this->userRepository->getUserById($userId);
            return view('products.show', ['products' => $products, 'user_name' => $user->name]);
        } else if (Auth::user()?->id != $userId) {
            abort(403, 'Unauthorized Action');
        }
        $products = $this->productRepository->getProductsByUserId($userId);
        $user = $this->userRepository->getUserById($userId);
        return view('products.show', ['products' => $products, 'user_name' => $user->name]);
    }

    public function edit($id)
    {
        $product = $this->productRepository->getProductByProductId($id);
        if (Auth::user()?->id != $product->user_id) {
            abort(403, 'Unauthorized Action');
        }
        if (Cache::has('allStocks')) {
            $stocks = Cache::get('allStocks');
        } else {
            $stocks = Stock::all();
            Cache::put('allStocks', $stocks, now()->addMinutes(10));
        }
        return view('products.edit', ['product' => $product, 'stocks' => $stocks]);
    }

    public function update(Request $request)
    {
        $formFields = $request->validate([
            'price' => 'required|numeric|between:0,99999999.999',
            'description' => 'required|min:8',
            'stock_id' => 'required'
        ]);
        $product = $this->productRepository->getProductByProductId($request->productId);
        if ($request->hasFile('image')) {
            if (File::exists(public_path('storage/' . $product->image))) {
                File::delete(public_path('storage/' . $product->image));
            }
            $formFields['image'] = $request->file('image')->store('productImage', 'public');
        }

        $this->productRepository->updateProduct($request->productId, $formFields);

        $productTypeName = $this->productTypeRepository->getProductTypeNameById($request->product_type_id);
        $stock = Stock::where('id', '=', $request->stock_id)->first();

        $productHistory['product_name'] = $product->name;
        $productHistory['product_price'] = $request->price;
        $productHistory['product_type'] = $productTypeName->name;
        $productHistory['user_id'] = $request->userId;
        $productHistory['action'] = "Product Updated";
        $productHistory['stock'] = $stock->name;

        $this->productHistoryRepository->addProductHistory($productHistory);

        Cache::forget('allProducts');
        Cache::forget('allProductHistories');

        return redirect('showProductByVendorId/' . Auth::user()?->id)->with('message', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = $this->productRepository->getProductByProductId($id);
        if (File::exists(public_path('storage/' . $product->image))) {
            File::delete(public_path('storage/' . $product->image));
        }
        $productTypeName = $this->productTypeRepository->getProductTypeNameById($product->product_type_id);
        $stock = Stock::where('id', '=', $product->stock_id)->first();


        $productHistory['product_name'] = $product->name;
        $productHistory['product_price'] = $product->price;
        $productHistory['product_type'] = $productTypeName->name;
        $productHistory['user_id'] = $product->user_id;
        $productHistory['action'] = "Product Deleted";
        $productHistory['stock'] = $stock->name;

        $this->productHistoryRepository->addProductHistory($productHistory);

        $this->productRepository->deleteProduct($id);
        Cache::forget('allProducts');
        Cache::forget('allProductHistories');
        return redirect('showProductByVendorId/' . Auth::user()?->id)->with('message', 'Product deleted successfully');
    }
    public function productsByProductTypeApi($productTypeId)
    {
        $productsByProductsType = $this->productRepository->productsByProductType($productTypeId);
        return $productsByProductsType;
    }
}
