<x-layout>
    <x-form-card>
        <h3 class="text-center">Create Product Type</h3>
        <form method="POST" action="{{asset('addProductType')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="name" placeholder="Name"
                    value="{{ old('name') }}">
                <label for="floatingInput">Product Type Name</label>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </x-form-card>
</x-layout>
