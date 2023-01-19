<x-layout>
    <x-alert />
    <x-container>
        <div class="d-flex flex-row-reverse">
            <a class="btn btn-outline-primary" href="{{ asset('productTypeCreateForm') }}">Add Product Type</a>
        </div>
        <x-header>Product Types</x-header>
        @if (count($productTypes) == 0)
            <x-header>No Product Types found</x-header>
        @endif
        <x-table>
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
        </x-table>
    </x-container>
</x-layout>
