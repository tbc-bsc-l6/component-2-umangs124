<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductTypeRepositoryInterface;
use App\Repositories\ProductTypeRepository;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    private ProductTypeRepositoryInterface $productTypeRepository;
    public function __construct()
    {
        $this->productTypeRepository = new ProductTypeRepository();
    }

    public function index()
    {
        $productTypes = $this->productTypeRepository->getAllProductTypes();
        return view('product_types.index', ['productTypes' => $productTypes]);
    }
    public function create()
    {
        return view('product_types.create');
    }
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required|min:3|unique:product_types',
        ]);
        $this->productTypeRepository->addProductTypes($formFields);
        return redirect('showProductTypes')->with('message', 'Product Type Added successfully');
    }
    public function destroy($id)
    {
        $this->productTypeRepository->deleteProductTypes($id);
        return redirect('showProductTypes')->with('message', 'Product Type Deleted successfully');;
    }
}
