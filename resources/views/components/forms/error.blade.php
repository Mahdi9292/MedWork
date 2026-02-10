@error($field, $bag)
    <div id="{{$field}}-error"  {{ $attributes->merge(['class' => 'invalid-feedback']) }}>
        @if ($slot->isEmpty())
            {{ $message }}
        @else
            {{ $slot }}
        @endif
    </div>
@enderror
