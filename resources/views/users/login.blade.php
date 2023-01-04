<x-layout>
    <div class="shadow-lg p-3 mb-5 bg-body rounded col-5 mx-auto mt-4">
        <h3 class="text-center">Login</h3>
        <form method="POST" action={{ asset('users/login') }} enctype="multipart/form-data">
            @csrf
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="floatingInput" name="email" placeholder="Email Address"
                    value="{{ old('email') }}">
                <label for="floatingInput">Email Address</label>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingInput" name="password" placeholder="password">
                <label for="floatingInput">Password</label>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            {{-- <input type="hidden" name="roleId" value={{ $roleId }}> --}}
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</x-layout>
