@if ($hasLabel($slot))
    <label @if ($for) for="{{ $for }}" @endif {{ $attributes->class(['col-form-label']) }}>
        @if ($slot->isEmpty())
            {{ $fallback }}
        @else
            {{ $slot }}
        @endif
        @if($requiredAsterisk)
            <span class="text-danger">*</span>
        @endif
    </label>
@endif
