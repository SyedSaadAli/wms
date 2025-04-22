{{-- Check if there is a success message in the session --}}
@if (!empty(session('success')))
    <div class="alert alert-success" role="alert">
        {{ session('success') }} {{-- Display success message --}}
    </div>
@endif

{{-- Check if there is an error message in the session --}}
@if (!empty(session('error')))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }} {{-- Display error message --}}
    </div>
@endif
