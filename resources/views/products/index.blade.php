<x-layout>
    <x-container>
        <x-header>All Products</x-header>
        <div class="d-flex flex-row-reverse">
            <div class="btn-group">
                <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Product Types
                </button>
                <ul class="dropdown-menu">
                    @foreach ($productTypes as $productType)
                        <li><a class="dropdown-item" target="_blank"
                                href="http://localhost:3000/products/{{ $productType->id }}/{{ $productType->name }}">{{ $productType->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
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
                </div>
            </x-card>
        @endforeach
    </x-container>
</x-layout>
