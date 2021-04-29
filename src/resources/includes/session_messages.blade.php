{{-- SUCCESS --}}
@if (session('success'))
    <div class="alert success">
        <p>{{ session()->get('success') }}</p>
    </div>
@endif

{{-- ERRORS --}}
@if ($errors->any())
    <div class="alert error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{!! $error !!}</li>
            @endforeach
        </ul>
    </div>
@endif
