@if (!empty($message))
    <div role="alert" {{ $attributes->class(['alert', 'alert-dismissible' => $removable, 'fade', 'show', 'alert-'.$type]) }}>

        {{-- The Icon before Message --}}
        @if ($icon)
            <span @class([
                $iconClass,
                'fas',
                'fa',
                "fa-$icon",
                'me-1',
                'blink' => $blinkIcon,
            ])></span>
        @endif

        <span>{{ $message }}</span>

        {{-- The close Button --}}
        @if ($removable)
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
        @endif

        {{-- Allow additional HTML --}}
        {{ $slot }}

    </div>
@endif
