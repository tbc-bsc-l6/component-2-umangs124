<x-layout>
    <x-form-card>
        <h3 class="text-center">Update User</h3>
        <form method="POST" action="{{asset('updateVendor/' . $user->id)}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="name" placeholder="Name"
                    value="{{ $user->name }}">
                <label for="floatingInput">Your Name</label>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="floatingInput" name="email" placeholder="Email Address"
                    value="{{ $user->email }}">
                <label for="floatingInput">Email Address</label>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <input type="file" class="form-control mb-3" class="border border-gray-200 rounded p-2 w-full"
                name="image" />
            <div>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            <div class="d-flex flex-row-reverse">
                <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('/images/blank-profile-picture.png') }}"
                    class="rounded-circle img-fluid" style="width: 150px; height: 150px;">
            </div>
            <input type="hidden" name="userId" value={{ $user->id }}>
        </form>
    </x-form-card>
</x-layout>
