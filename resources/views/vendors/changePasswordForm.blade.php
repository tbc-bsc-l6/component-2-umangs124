<x-layout>
    <div class="shadow-lg p-3 mb-5 bg-body rounded col-5 mx-auto mt-4">
        <h3 class="text-center">Change Password</h3>
        <form method="POST" action="{{ asset('sendVerificationCode') }}" enctype="multipart/form-data">
            @csrf
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
            <button type="submit" class="btn btn-primary mt-2">Submit</button>
        </form>
    </div>
</x-layout>
