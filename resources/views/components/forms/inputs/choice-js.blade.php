@include('components.forms.before')

<div @class(['is-invalid' => $hasErrorsAndShow($name)]) >
    <div wire:ignore
         x-data="{
            @if($attributes->wire('model')->value)
                selectedValue: @entangle($attributes->wire('model')).live,
            @else
                selectedValue: '{{ $multiple ? json_encode($value) : $value }}',
            @endif
            choiceDropDown: null,
            initChoice() {
                this.choiceDropDown = new Choices($refs.choices, {{ $jsonOptions() }});
                this.choiceDropDown.setChoiceByValue({{ json_encode($convertToStringArray($value)) }});
                $refs.choices.addEventListener('change', (event) => {
                    this.selectedValue = this.choiceDropDown.getValue(true);
                })
            },
        }"
    >
        <select
            x-init="initChoice()"
            x-ref="choices"
            x-model="this.selectedValue"
            name="{{ $name }}"
            id="{{ $id }}"
            placeholder="{{ $placeholder }}"
            {{ ($required ?? false) ? 'required' : '' }}
            @if ($multiple) multiple @endif
            {{ $attributes->merge(['class' => $inputClass()])->whereDoesntStartWith('wire:model.live') }}
        >
            @foreach ($options as $key => $label)
                <option value="{{ $key }}" @if ($isSelected($key)) selected @endif>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>
</div>

@if ($hasErrorsAndShow($name))
    @error($name)
    <x-form.error :field="$name" />
    @enderror
@endif

@include('components.forms.after')
