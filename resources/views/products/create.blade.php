<x-layout>
    <x-form-card>
        <h3 class="text-center">Create Product</h3>
        <form method="POST" action="{{ asset('createProduct') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="name" placeholder="Name"
                    value="{{ old('name') }}">
                <label for="floatingInput">Product Name</label>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="price" placeholder="Price"
                    value="{{ old('price') }}">
                <label for="floatingInput">Product Price</label>
                @error('price')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="description"
                    placeholder="Description" value="{{ old('description') }}">
                <label for="floatingInput">Product Description</label>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <select name="product_type_id" class="form-select form-select-lg mb-1" aria-label=".form-select-lg example">
                <option value="" selected>Select Product Type</option>
                @foreach ($productTypes as $productType)
                    <option value="{{ $productType->id }}">{{ $productType->name }}</option>
                @endforeach
            </select>
            @error('product_type_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <input type="file" class="form-control mb-3 mt-3" class="border border-gray-200 rounded p-2 w-full"
                name="image" />
            @foreach ($stocks as $stock)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="stock_id" id="inlineRadio1"
                        value="{{ $stock->id }}">
                    <label class="form-check-label" for="inlineRadio1">{{ $stock->name }}</label>
                </div>
            @endforeach
            <br />
            @error('stock_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <br />
            <input type="hidden" name="userId" value={{ Auth::user()?->id }}>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </x-form-card>
</x-layout>
