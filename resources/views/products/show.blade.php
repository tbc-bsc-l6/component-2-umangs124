<x-layout>
    <x-alert />
    <x-container>
        <x-header>{{ $user_name }} Products</x-header>
        @if (count($products) == 0)
            <x-header>No Products found</x-header>
        @endif
        @foreach ($products as $product)
            <x-card>
                <div class="text-center">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/no-product-image.jpg') }}"
                        class="rounded-circle img-fluid" style="width: 150px; height: 150px;">
                </div>
                <div class="card-body">
                    <h5 class="my-3 text-center">{{ $product->name }}</h5>
                    @if ($product->stock_id == 1)
                        <i class="text-success d-flex flex-row-reverse">{{ $product->stockName }}</i>
                    @endif
                    @if ($product->stock_id == 2)
                        <i class="text-danger d-flex flex-row-reverse">{{ $product->stockName }}</i>
                    @endif
                    <ul class="list-group mb-3">
                        <li class="list-group-item">Price : ${{ $product->price }}</li>
                        <li class="list-group-item">Description : {{ $product->description }}</li>
                        <li class="list-group-item">Product Type : {{ $product->productType }}</li>
                    </ul>
                    <div class="d-flex justify-content-center mb-2">
                        <a href="{{ asset('showEditProductForm/' . $product->id) }}" class="btn btn-primary">Edit</a>
                        <form method="POST" action="{{ asset('deleteProduct/' . $product->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger ms-2" type="submit">Delete</button>
                        </form>
                    </div>
                </div>
            </x-card>
        @endforeach
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </x-container>
</x-layout>
