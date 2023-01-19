<x-layout>
    <x-form-card>
        <h3 class="text-center">Enter Verification Code</h3>
        <form method="POST" action="{{ asset('verifyVerificationCode') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="code" placeholder="password">
                <label for="floatingInput">Enter Code</label>
                @error('verification_token')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-2">Submit</button>
        </form>
    </x-form-card>
</x-layout>
