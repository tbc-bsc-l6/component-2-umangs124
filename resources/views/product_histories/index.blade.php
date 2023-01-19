<x-layout>
    <x-alert />
    <x-container>
        <x-header>Product Histories</x-header>
        @if (count($productHistories) == 0)
            <x-header>No Product Histories found</x-header>
        @endif
        <x-table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Product Type</th>
                    <th>Stock</th>
                    <th>Action Name</th>
                    <th>Action Date</th>
                    <th>Action Done By</th>
                    <th>Action</th>
                </tr>
            </thead>
            @foreach ($productHistories as $productHistory)
                <tbody>
                    <tr>
                        <td>{{ $productHistory->product_name }}</td>
                        <td>${{ $productHistory->product_price }}</td>
                        <td>{{ $productHistory->product_type }}</td>
                        <td>
                            @if ($productHistory->stock == 'In Stock')
                                <i class="text-success">{{ $productHistory->stock }}</i>
                            @endif
                            @if ($productHistory->stock == 'Out Of Stock')
                                <i class="text-danger">{{ $productHistory->stock }}</i>
                            @endif
                        </td>
                        <td>{{ $productHistory->action }}</td>
                        <td>{{ $productHistory->created_at }}</td>
                        <td>{{ $productHistory->userName }}</td>
                        <td>
                            <form method="POST" action="{{ asset('deleteProductHistories/' . $productHistory->id) }}">
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
