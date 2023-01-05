<x-layout>
    
    <div class="shadow-lg p-3 mb-5 bg-body rounded col-5 mx-auto mt-4">
        <h3 class="text-center">Update Product</h3>
        <form method="POST" action="{{ asset('updateProduct/' . $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="price" placeholder="Price"
                    value="{{ $product->price }}">
                <label for="floatingInput">Product Price</label>
                @error('price')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="description" placeholder="Description"
                    value="{{ $product->description }}">
                <label for="floatingInput">Product Description</label>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <input type="file" class="form-control mb-3" class="border border-gray-200 rounded p-2 w-full"
                name="image" />
            <div>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            <div class="d-flex flex-row-reverse">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('/images/no-product-image.jpg') }}"
                    class="rounded-circle img-fluid" style="width: 150px; height: 150px;">
            </div>
            <input type="hidden" name="productId" value={{ $product->id }}>
            <input type="hidden" name="userId" value={{ Auth::user()?->id }}>
            <input type="hidden" name="productType" value={{ $product->product_type_id }}>
        </form>
    </div>
</x-layout>
