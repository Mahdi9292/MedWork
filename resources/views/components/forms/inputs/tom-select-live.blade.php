@include('components.forms.before')

<div @class(['p-0', 'removeValidationAfter', 'lw-validation',  'is-invalid' => $hasErrorsAndShow(str_replace('[]','',$name)), 'valid' => !$hasErrorsAndShow(str_replace('[]','',$name)), 'is-valid' => (!$hasErrorsAndShow(str_replace('[]','',$name)) && $value) ]) >

    <div wire:ignore
         x-data="{
            modelValue: $wire.entangle('{{ $modelName() }}'),
            tomSelectDropDown: null,
            initTomSelect(removeVal=true) {
                //console.log($el.firstElementChild?.getAttribute('wire:model.live'));
                this.tomSelectDropDown = new TomSelect($refs.tomChoices_{{ $referenceName }}, {{ $jsonOptions() }});

                if(removeVal){
                    $el.closest('.removeValidationAfter').classList.remove('is-valid');
                }
            },
            reSync() {
                let val = this.tomSelectDropDown.getValue();
                this.tomSelectDropDown.destroy();
                this.initTomSelect(false);
                this.tomSelectDropDown.setValue(this.modelValue, true);
            },
        }"
    >
        <select
            @re-init-alpine-component.window="reSync()"
            x-init="initTomSelect(); $watch('modelValue', value => reSync())"
            x-on:mouseenter="reSync()"
            @focus="reSync()"
            x-ref="tomChoices_{{ $referenceName }}"
            name="{{ $name }}"
            id="{{ $id }}"
            placeholder="{{ $placeholder }}"
            {{ ($required ?? false) ? 'required' : '' }}
            @if ($multiple) multiple @endif
            {{ $attributes->merge(['class' => $inputClass()]) }}
        >
            @foreach ($options as $key => $label)
                <option value="{{ $key }}" @if ($isSelected($key)) selected @endif>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>

@if ($hasErrorsAndShow(str_replace('[]','',$name)))
    @error(str_replace('[]','',$name))
    <x-form.error :field="str_replace('[]','',$name)" />
    @enderror
@endif

@include('components.forms.after')
