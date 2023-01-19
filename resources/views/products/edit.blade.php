<x-layout>
    <x-form-card>
        <h3 class="text-center">Update {{ $product->name }}</h3>
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
                <input type="text" class="form-control" id="floatingInput" name="description"
                    placeholder="Description" value="{{ $product->description }}">
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
            @foreach ($stocks as $stock)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="stock_id" id="inlineRadio1"
                        value="{{ $stock->id }}">
                    <label class="form-check-label" for="inlineRadio1">{{ $stock->name }}</label>
                </div>
            @endforeach
            @error('stock_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <br>
            <input type="hidden" name="productId" value={{ $product->id }}>
            <input type="hidden" name="userId" value={{ Auth::user()?->id }}>
            <input type="hidden" name="product_type_id" value={{ $product->product_type_id }}>
        </form>
    </x-form-card>
</x-layout>
