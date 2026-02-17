@include('components.forms.before')

<div class="removeValidationAfter"
     x-data="{
        picker: null,
        initPicker() {
            // Destroy existing instance if repeater cloned a 'live' element
            if (this.picker) { this.picker.destroy(); }

            this.picker = new Datepicker($refs.myInput, {
                buttonClass: 'btn',
                format: 'dd.mm.yyyy', // Your desired display format
                language: 'de',
                autohide: true
            });
        }
     }">
    <div class="input-group">
        <input
            x-ref="myInput"
            x-init="initPicker()"
            {{-- Re-init on mouseenter helps if the repeater clones the row without Alpine noticing --}}
            x-on:mouseenter="if(!picker) initPicker()"
            name="{{ $name }}"
            value="{{ $value ?? '' }}"
            type="text"
            {{ $attributes->merge(['class' => 'form-control']) }}
            placeholder=""
        />
        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
    </div>
</div>

@include('components.forms.after')
