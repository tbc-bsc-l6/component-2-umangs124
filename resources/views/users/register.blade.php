<x-layout>
    <x-form-card>
        <h3 class="text-center">Sign up</h3>
        <form method="POST" action="{{ asset('users/register') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="name" placeholder="Name"
                    value="{{ old('name') }}">
                <label for="floatingInput">Your Name</label>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
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
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingInput" name="password_confirmation"
                    placeholder="confirm password">
                <label for="floatingInput">Confirm Password</label>
                @error('password_confirmation')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <input type="file" class="form-control mb-3" class="border border-gray-200 rounded p-2 w-full"
                name="image" />
            @foreach ($roles as $role)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="role_id" id="inlineRadio1"
                        value="{{ $role->id }}">
                    <label class="form-check-label" for="inlineRadio1">{{ $role->name }}</label>
                </div>
            @endforeach
            @error('role_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <br />
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary mt-2">Register</button>
                <div class="mt-3">
                    Already have an account? <a aria-current="page" href="{{ asset('users/showLoginForm') }}">Login</a>
                </div>
            </div>

        </form>
    </x-form-card>
</x-layout>
