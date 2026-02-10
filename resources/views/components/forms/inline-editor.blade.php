@include('components.forms.before')

<div
    x-data="{
        isEditing: false,
        // Initialize based on type: boolean for checkboxes, string for others
        localValue: @if($type === 'checkbox') {{ $value ? 'true' : 'false' }} @else {{ json_encode(is_array($value) ? implode(', ', $value) : $value) }} @endif,
        initialValue: @if($type === 'checkbox') {{ $value ? 'true' : 'false' }} @else {{ json_encode(is_array($value) ? implode(', ', $value) : $value) }} @endif,

        updateValue() {
            this.isEditing = false;
            // Call the Livewire method
            @this.call('{{ $livewireSaveMethod }}', {{ $id }}, '{{ $name }}', this.localValue);
        },

        cancelEdit() {
            this.localValue = this.initialValue;
            this.isEditing = false;
        }
    }"
    x-id="['inline-edit-{{ $name }}']"
    {{ $attributes->whereStartsWith('wire:key') }}
    class="d-flex align-items-start"
>

    {{-- 1. READ-ONLY STATE --}}
    {{-- We bind 'd-flex' conditionally so it doesn't override 'display: none' --}}
    <div
        x-show="!isEditing"
        :class="{ 'd-flex': !isEditing }"
        class="align-items-center justify-content-between w-100"
    >

        <div
            id="{{ $id }}"
            @if($bgColor && $type != 'checkbox') style="background-color: {{ $bgColor }}; min-height: 36px;"@endif
            {{ $attributes->whereDoesntStartWith('wire:key')->merge(['class' => $inputClass() . ' d-flex align-items-center flex-grow-1 me-2']) }}
        >

            @if($type == 'checkbox')
                {!! $value==1 ? '<i class="fa fa-check-square"></i>' : '<i class="far fa-square"></i>' !!}
            @elseif($type == 'boolean')
                {!! $value==1 ? 'JA' : 'Nein' !!}
            @else
                <span style="white-space: pre-line;" x-text="localValue" class="text-break"></span>
            @endif

            @if ($hasErrorsAndShow($name))
                @error($name)
                <x-form.error :field="$name" />
                @enderror
            @endif
        </div>

        {{-- Edit Trigger --}}
        @if($editable)
            <button type="button"
                    @click="isEditing = true; $nextTick(() => $refs.editField.focus())"
                    class="btn btn-sm btn-link p-0 text-primary hover-shadow-none align-self-end"
                    style="text-decoration: none;">
                <i class="fas fa-pencil-alt fa-fw"></i>
            </button>
        @endif
    </div>

    {{-- 2. EDITABLE STATE --}}
    {{-- We bind 'd-flex' conditionally and use inline style to prevent FOUC --}}
    <div
        x-show="isEditing"
        :class="{ 'd-flex': isEditing }"
        class="align-items-center w-100"
        style="display: none;"
    >

        @if($type === 'textarea')
            <textarea
                x-model.debounce.500ms="localValue"
                x-ref="editField"
                @keydown.escape.prevent="cancelEdit()"
                :id="$id('inline-edit-{{ $name }}')"
                class="form-control form-control-sm me-2"
                rows="3"
                style="min-width: 150px;"
                @class(['is-invalid' => $errors->has($name)])></textarea>
        @elseif($type === 'checkbox')
            <div class="form-check me-2">
                <input
                    type="checkbox"
                    x-model="localValue"
                    x-ref="editField"
                    @keydown.escape.prevent="cancelEdit()"
                    :id="$id('inline-edit-{{ $name }}')"
                    class="form-check-input"
                    @class(['is-invalid' => $errors->has($name)])>
            </div>
        @else
            {{-- Default Text Input --}}
            <input type="text"
                   x-model.debounce.500ms="localValue"
                   x-ref="editField"
                   @keydown.enter.prevent="updateValue()"
                   @keydown.escape.prevent="cancelEdit()"
                   :id="$id('inline-edit-{{ $name }}')"
                   class="form-control form-control-sm me-2"
                   style="min-width: 150px;"
                @class(['is-invalid' => $errors->has($name)])>
        @endif

        <button type="button" @click="updateValue()" class="btn btn-sm btn-offwhite me-1 align-self-end">
            <i class="fas fa-save fa-fw"></i>
        </button>

        <button type="button" @click="cancelEdit()" class="btn btn-sm btn-offwhite align-self-end">
            <i class="fas fa-times fa-fw"></i>
        </button>
    </div>

</div>

@include('components.forms.after')
