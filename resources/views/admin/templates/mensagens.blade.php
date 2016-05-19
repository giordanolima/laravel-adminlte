<div class='alert {{ $errors->count() == 0 ? (session('ok') ? 'alert-success' : 'hide') : 'alert-danger' }}'>
    <ul>
        @foreach ($errors->all() as $erro)
        <li>{{ $erro }}</li>
        @endforeach

        @if (session('ok'))
        <li>{{ session('ok') }}</li>
        @endif
    </ul>
</div>