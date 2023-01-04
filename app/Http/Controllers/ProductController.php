<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Show all Product
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('products.index', ['products' => Product::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productTypes = DB::table('product_types')->get();
        return view('products.create', ['productTypes' => $productTypes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //dd($request);
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
        $product = Product::create($formFields);

        $productTypeName = DB::table('product_types')->select('name')->where('id', '=', $request->productType)->first();

        // dd($productTypeName);

        $productHistory['product_name'] = $product->name;
        $productHistory['product_price'] = $product->price;
        $productHistory['product_type'] = $productTypeName->name;
        $productHistory['user_id'] = $request->userId;
        $productHistory['action'] = "Product Added";
        ProductHistory::create($productHistory);
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $products = Product::query('products')
        ->join('product_types', 'products.product_type_id', '=', 'product_types.id')
        ->select('products.*', 'product_types.name as productType')
        ->where('user_id', '=', Auth::user()?->id)
        ->filter(request(['product_search']))->paginate(4);
     //   dd($products);
        return view('products.show', ['products' => $products]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
