<x-layout>
    <div class="shadow-lg p-3 mb-5 bg-body rounded col-5 mx-auto mt-4">
        <h3 class="text-center">Create Product</h3>
        <form method="POST" action="{{asset('createProduct')}}" enctype="multipart/form-data">
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
                <input type="text" class="form-control" id="floatingInput" name="description" placeholder="Description"
                    value="{{ old('description') }}">
                <label for="floatingInput">Product Description</label>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <select name="productType" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                <option selected>Select Product Type</option>
                @foreach ($productTypes as $productType)
                <option value="{{$productType->id}}">{{$productType->name}}</option>
                @endforeach
            </select>
            <input type="file" class="form-control mb-3 mt-3" class="border border-gray-200 rounded p-2 w-full"
                name="image" />
            <input type="hidden" name="userId" value={{ Auth::user()?->id }}>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</x-layout>
