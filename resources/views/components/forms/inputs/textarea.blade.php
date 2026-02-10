@include('components.forms.before')

<!-- using php for value to avoid livewire inject_morph_markers problem -->
<!--problem: [if BLOCK]><![endif]--> <!--[if ENDBLOCK]><![endif] vising in textareas -->
{{-- old code: @if (! is_null($value)){!! $value !!}@elseif ($slot->isNotEmpty()){!! $slot !!}@endif--}}
@php
    $valueVar = '';
    if (! is_null($value)){
        $valueVar = $value;
    }elseif ($slot->isNotEmpty()){
        $valueVar = $slot;
    }
@endphp

<textarea
    name="{{ $name }}"
    id="{{ $id }}"
    rows="{{ $rows }}"
    @if ($hasErrorsAndShow($name))
        aria-invalid="true"
        @if (! $attributes->offsetExists('aria-describedby'))
            aria-describedby="{{ $id }}-error"
        @endif
    @endif
    {!! $attributes->merge(['class' => $inputClass(), 'rows' => 3]) !!}
>{!! $valueVar !!}</textarea>

@if ($hasErrorsAndShow($name))
    @error($name)
        <x-form.error :field="$name" />
    @enderror
@endif

@include('components.forms.after')
