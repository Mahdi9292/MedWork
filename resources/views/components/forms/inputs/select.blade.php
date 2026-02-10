@include('components.forms.before')

    <select
        name="{{ $name }}"
        id="{{ $id }}"
        @if ($multiple) multiple @endif

        @if ($hasErrorsAndShow($name))
            aria-invalid="true"

            @if (! $attributes->offsetExists('aria-describedby'))
                aria-describedby="{{ $id }}-error"
            @endif
        @endif

        {{ $attributes->merge(['class' => $inputClass()]) }}
        {{ ($required ?? false) ? 'required' : '' }}
    >
        {{ $slot }}

        @foreach ($options as $key => $label)
            <option value="{{ $key }}" @if ($isSelected($key)) selected @endif>
                {{ $label }}
            </option>
        @endforeach

        {{ $append ?? '' }}
    </select>

    @if ($hasErrorsAndShow($name))
        @error($name)
            <x-form.error :field="$name" />
        @enderror
    @endif
    <!-- <div class="invalid-feedback">Dies ist ein Pflichtfeld</div> -->

@include('components.forms.after')
