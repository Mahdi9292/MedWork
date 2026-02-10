@include('components.forms.before')

<div wire:key="datepicker-{{ rand() }}" @class(['removeValidationAfter', 'lw-validation', 'is-invalid' => $hasErrorsAndShow($name), 'is-valid' => (!$hasErrorsAndShow($name) && $value) ])>
    <div class="input-group" wire:ignore
         x-data="{instance: undefined}"
         x-init="instance = flatpickr($refs.mDatePickerInput, {{ $setup() }});"
         @if(isset($config["mode"]) && $config["mode"] == "range" && $attributes->get('live'))
             @change="const value = $event.target.value; if(value.split('to').length == 2) { $wire.set('{{ $modelName() }}', value) };"
         @endif
         x-on:livewire:navigating.window="instance.destroy();"
    >
        <input
            x-ref="mDatePickerInput"
            {{
                $attributes
                    ->merge(['type' => 'date'])
                    ->class($inputClass())
            }}
        />
        <span class="input-group-text text-darkcyan has-js-validation" @click="instance.open()" title="{{ __('Kalender öffnen') }}"><span class="far fa-calendar-alt"></span></span>
        <span class="input-group-text text-light-orange has-js-validation" title="{{ __('löschen') }}" data-clear @click="instance.clear()">
            <i class="fas fa-times-circle"></i>
        </span>
    </div>
</div>
@if ($hasErrorsAndShow($name))
    @error($name)
        <x-form.error :field="$name" />
    @enderror
@endif

@include('components.forms.after')
