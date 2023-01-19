<x-layout>
    <x-form-card>
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
                <input type="password" class="form-control" id="myInput" name="password" placeholder="password">
                <label for="floatingInput">Password</label>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            Don't have an account? <a aria-current="page"
                href="{{ asset('users/showRegisterForm') }}">Register</a>
            <span class="d-flex flex-row-reverse me-2">
                <input type="checkbox" onclick="myFunction()"><span class="m-1">Show Password</span>
            </span>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </x-form-card>
</x-layout>

<script>
    function myFunction() {
        var x = document.getElementById("myInput");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
