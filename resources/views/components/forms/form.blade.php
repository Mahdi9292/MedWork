<form method="{{ $method !== 'GET' ? 'POST' : 'GET' }}" action="{{ $action }}" {!! $hasFiles ? 'enctype="multipart/form-data"' : '' !!} {{ $attributes->class(['requires-validation' => $hasJsValidation]) }}>
    @if($method !== 'GET')
        @csrf
        @method($method)
    @endif

    {{ $slot }}
</form>
