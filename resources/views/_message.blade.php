@if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show text-sm" role="alert">
        {{ session()->get('success') }}
    </div>
@endif

@if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show text-sm" role="alert">
        {{ session()->get('error') }}
    </div>
@endif
