<x-layout>
    <x-alert />
    <div class="container mb-4">
        <div class="row g-2 mt-4">
            <div class="d-flex flex-row-reverse">
                <a class="btn btn-outline-primary" href="{{ asset('productTypeCreateForm') }}">Add Product Type</a>
            </div>

            <h4 class="text-center shadow-lg p-3 bg-body rounded">Product Types</h4>
            @if (count($productTypes) == 0)
                <p>No Product Types found</p>
            @endif
            <div class="shadow-lg p-3 bg-body rounded" style="width: 100%; height: 100%;">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product Types</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    @foreach ($productTypes as $productType)
                        <tbody>
                            <tr>
                                <td>{{ $productType->name }}</td>
                                <td>{{ $productType->created_at }}</td>
                                <td>
                                    <form method="POST" action="{{ asset('deleteProductType/' . $productType->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger ms-2" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</x-layout>
