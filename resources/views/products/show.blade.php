<x-layout>
    <div class="container  mb-4">
        <div class="row g-2 mt-4">
            @if (count($products) == 0)
                <p>No Products found</p>
            @endif
            @foreach ($products as $product)
                <div class="col-lg-4 col-md-6">
                    <div class="shadow-lg p-3 bg-body rounded" style="width: 100%; height: 100%;">
                        <div class="text-center">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/blank-profile-picture.png') }}"
                                class="rounded-circle img-fluid" style="width: 150px; height: 150px;">
                        </div>
                        <div class="card-body">
                            <h5 class="my-3 text-center">{{ $product->name }}</h5>
                            <ul class="list-group mb-3">
                                <li class="list-group-item">Price : ${{ $product->price }}</li>
                                <li class="list-group-item">Description : {{ $product->description }}</li>
                                <li class="list-group-item">Product Type : {{ $product->productType }}</li>
                            </ul>
                            <div class="d-flex justify-content-center mb-2">
                                <a href="#" class="btn btn-primary">Edit</a>
                                <form method="POST" action="#">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger ms-2" type="submit">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</x-layout>