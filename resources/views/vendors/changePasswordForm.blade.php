<x-layout>
    <x-form-card>
        <h3 class="text-center">Change Password</h3>
        <form method="POST" action="{{ asset('sendVerificationCode') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-floating mb-3">
                <input type="password" id="myInput1" class="form-control" id="floatingInput" name="password" placeholder="password">
                <label for="floatingInput">Password</label>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="password" id="myInput" class="form-control" id="floatingInput" name="password_confirmation"
                    placeholder="confirm password">
                <label for="floatingInput">Confirm Password</label>
                @error('password_confirmation')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <span class="d-flex flex-row-reverse me-2">
                <input type="checkbox" onclick="myFunction()"><span class="m-1">Show Password</span>
            </span>
            <button type="submit" class="btn btn-primary mt-2">Submit</button>
        </form>
    </x-form-card>
</x-layout>
<script>
    function myFunction() {
        var x = document.getElementById("myInput");
        var x1 = document.getElementById("myInput1");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x1.type = "password";
        }
        if (x1.type === "password") {
            x1.type = "text";
        } else {
            x1.type = "password";
        }
    }
</script>
