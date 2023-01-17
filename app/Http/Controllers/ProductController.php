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
use Illuminate\Support\Facades\File;

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
        $products = $this->productRepository->getAllProducts();
        $productTypes = $this->productTypeRepository->getAllProductTypes();
        return view('products.index', ['products' => $products, 'productTypes' => $productTypes]);
    }
    public function create()
    {

        $productTypes = $this->productRepository->getAllProductTypes();
        $stocks = Stock::all();
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

        $productTypeName = $this->productRepository->getProductTypeNameById($request->product_type_id);
        $productHistory['product_name'] = $product->name;
        $productHistory['product_price'] = $product->price;
        $productHistory['product_type'] = $productTypeName->name;
        $productHistory['user_id'] = $request->userId;
        $productHistory['action'] = "Product Added";
        $productHistory['stock'] = $stock->name;
        $this->productHistoryRepository->addProductHistory($productHistory);
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
        $stocks = Stock::all();
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


        $productTypeName = $this->productRepository->getProductTypeNameById($request->product_type_id);
        $stock = Stock::where('id', '=', $request->stock_id)->first();

        $productHistory['product_name'] = $product->name;
        $productHistory['product_price'] = $request->price;
        $productHistory['product_type'] = $productTypeName->name;
        $productHistory['user_id'] = $request->userId;
        $productHistory['action'] = "Product Updated";
        $productHistory['stock'] = $stock->name;

        $this->productHistoryRepository->addProductHistory($productHistory);

        return redirect('showProductByVendorId/' . Auth::user()?->id)->with('message', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = $this->productRepository->getProductByProductId($id);
        if (File::exists(public_path('storage/' . $product->image))) {
            File::delete(public_path('storage/' . $product->image));
        }
        $this->productRepository->deleteProduct($id);

        return redirect('showProductByVendorId/' . Auth::user()?->id)->with('message', 'Product deleted successfully');
    }
    public function productsByProductTypeApi($productTypeId)
    {
        return $this->productRepository->productsByProductType($productTypeId);
    }
}
