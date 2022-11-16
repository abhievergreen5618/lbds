@if (session()->has('msg'))
    <div class="alert alert-success alert-dismissible fade show" role="alert"
        @isset($style) {{ $style }} @endisset>
        <p class="m-0">{{ session()->get('msg') }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
{{-- for display error alert --}}
@if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" @isset($style) {{ $style }} @endisset>
        <p class="m-0">{{ session()->get('error') }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


