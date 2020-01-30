@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session('success'))
    <div class="alert alert-success">
        <span>{{ session('success') }}</span>
    </div>
@endif
@if (session('failed'))
    <div class="alert alert-danger">
        <span>{{ session('failed') }}</span>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger">
        <span>{{ session('error') }}</span>
    </div>
@endif