<div>
    @if(session('success'))
        <div class="success-container">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="error-container">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    @if($errors->any())
        <div class="error-container">
            <p>{{ $errors->first() }}</p>
        </div>
    @endif
</div>