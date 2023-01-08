<x-layout>
    <x-alert />
    <div class="container mb-4">
        <div class="row g-2 mt-4">
            <h4 class="text-center shadow-lg p-3 bg-body rounded">Product Histories</h4>
            @if (count($productHistories) == 0)
                <p>No Product Histories found</p>
            @endif
            <div class="shadow-lg p-3 bg-body rounded" style="width: 100%; height: 100%;">
                <table class="table table-bordered">
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
                                <td>{{ $productHistory->product_price }}</td>
                                <td>{{ $productHistory->product_type }}</td>
                                <td>{{ $productHistory->stock }}</td>
                                <td>{{ $productHistory->action }}</td>
                                <td>{{ $productHistory->created_at }}</td>
                                <td>{{ $productHistory->userName }}</td>
                                <td>
                                    <form method="POST"
                                        action="{{ asset('deleteProductHistories/' . $productHistory->id) }}">
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
