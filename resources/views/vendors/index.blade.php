<x-layout>
    <x-alert />
    <div class="container text-center mb-4">
        <div class="row g-2 mt-4">
            
            <div class="d-flex flex-row-reverse">
                <a class="btn btn-outline-primary" href="{{ asset('showCreateVendorForm') }}">Add User</a>
            </div>
            @if (count($users) == 0)
                <p>No users found</p>
            @endif
            @foreach ($users as $user)
                <div class="col-lg-4 col-md-5">
                    <div class="shadow-lg p-3 bg-body rounded" style="width: 100%; height: 100%;">
                        <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('images/blank-profile-picture.png') }}"
                            class="rounded-circle img-fluid" style="width: 150px; height: 150px;">
                        <div class="card-body text-center">
                            <h5 class="my-3">{{ $user->name }}</h5>
                            <ul class="list-group mb-3">
                                <li class="list-group-item">Email Address : {{ $user->email }}</li>
                                <li class="list-group-item">Created at : {{ $user->created_at }}</li>
                            </ul>
                            <div class="mb-3 d-flex flex-row-reverse">
                                <a target="_blank" href="{{ asset('showProductByVendorId/' . $user->id) }}"><i><u>View Products</u></i></a>
                            </div>
                            <div class="d-flex justify-content-center mb-2">
                                <a href="{{ asset('showEditVendorForm/' . $user->id) }}"
                                    class="btn btn-primary">Edit</a>
                                <form method="POST" action="{{ asset('deleteVendor/' . $user->id) }}">
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
            {{ $users->links() }}
        </div>
    </div>
</x-layout>
