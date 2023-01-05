@if (session()->has('message'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" 
        x-show="show" class="alert alert-success col-6 mx-auto" role="alert">
        {{ session('message') }}
    </div>
@endif
