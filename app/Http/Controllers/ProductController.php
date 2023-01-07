<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductRepositoryInterface;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
    private ProductRepositoryInterface $productRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
    }
    public function index()
    {
        $products = $this->productRepository->getAllProducts();
        return view('products.index', ['products' => $products]);
    }
    public function create()
    {
        $productTypes = $this->productRepository->getAllProductTypes();
        return view('products.create', ['productTypes' => $productTypes]);
    }
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric|between:0,99999999.999',
            'description' => 'required|min:8'
        ]);
        if ($request->hasFile('image')) {
            $formFields['image'] = $request->file('image')->store('productImage', 'public');
        }
        $formFields['product_type_id'] = $request->productType;
        $formFields['user_id'] = $request->userId;

        $productId = $this->productRepository->addProducts($formFields);

        $product = $this->productRepository->getProductByProductId($productId);

        $productTypeName = $this->productRepository->getProductTypeNameById($request->productType);
        $productHistory['product_name'] = $product->name;
        $productHistory['product_price'] = $product->price;
        $productHistory['product_type'] = $productTypeName->name;
        $productHistory['user_id'] = $request->userId;
        $productHistory['action'] = "Product Added";
        $this->productRepository->addProductHistory($productHistory);
        return redirect('showProductByVendorId')->with('message', 'Product added successfully');
    }


    public function show()
    {
        $products = $this->productRepository->getProductsByUserId(Auth::user()?->id);
        return view('products.show', ['products' => $products]);
    }

    public function edit($id)
    {
        $product = $this->productRepository->getProductByProductId($id);
        return view('products.edit', ['product' => $product]);
    }

    public function update(Request $request)
    {
        $formFields = $request->validate([
            'price' => 'required|numeric|between:0,99999999.999',
            'description' => 'required|min:8'
        ]);
        if ($request->hasFile('image')) {
            $formFields['image'] = $request->file('image')->store('productImage', 'public');
        }
        $product = $this->productRepository->getProductByProductId($request->productId);
        $this->productRepository->updateProduct($request->productId, $formFields);

        $productTypeName = $this->productRepository->getProductTypeNameById($request->productType);

        $productHistory['product_name'] = $product->name;
        $productHistory['product_price'] = $request->price;
        $productHistory['product_type'] = $productTypeName->name;
        $productHistory['user_id'] = $request->userId;
        $productHistory['action'] = "Product Updated";

        $this->productRepository->addProductHistory($productHistory);

        return redirect('showProductByVendorId')->with('message', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $this->productRepository->deleteProduct($id);
        return redirect('showProductByVendorId')->with('message', 'Product deleted successfully');
    }
}
