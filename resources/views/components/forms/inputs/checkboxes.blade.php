@include('components.forms.before')

    @foreach ($options as $key => $optionLabel)
        <div class="form-check">
            <input 
                class="{{ $inputClass() }}" 
                type="checkbox" 
                name="{{ $name }}[]" 
                value="{{ $key }}" 
                id="{{ $id }}_{{ $key }}"
                @if ($isSelected($key)) checked @endif
                {{ $attributes->merge() }}
            >
            <label class="form-check-label" for="{{ $id }}_{{ $key }}">
                {{ $optionLabel }}
            </label>
        </div>
    @endforeach

    @if ($hasErrorsAndShow($name))
        @error($name)
            <x-form.error :field="$name" />
        @enderror
    @endif

@include('components.forms.after')
