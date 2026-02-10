@include('components.forms.before')

@if ($switch)<div class="form-check form-switch">@endif

<!-- hack to send "0" when checkbox is not selected -->
<input type="hidden" name="{{ $name }}" value="0" />

<input
    name="{{ $name }}"
    type="checkbox"
    id="{{ $id }}"
    value="1"
    @if(old($name, ($hasErrorsAndShow($name) ? false : $checked))) checked @endif
    {{ $attributes->merge(['class' => $inputClass()]) }}
/>
@if ($info)
    <label class="form-check-label" for="{{ $id }}">{{ $info }}</label>
@endif

@if ($hasErrorsAndShow($name))
    @error($name)
        <x-form.error :field="$name" />
    @enderror
@endif

@if ($switch)</div>@endif

@include('components.forms.after')
