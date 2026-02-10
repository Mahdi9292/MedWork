@include('components.forms.before')

{{--<div class="{{ $col }}">--}}

<div class="form-check form-check-inline">

<!-- hack to send "0" when checkbox is not selected -->
<input type="hidden" name="{{ $name }}" value="0" />
<label class="form-check-label" for="{{ $name . '_' .$value }}">{{$radioLabel}}</label>

<input
    name="{{ $name }}"
    type="radio"
    id="{{ $name . '_' .$value }}"
    value="{{ $value }}"
    @if(old($name, $errors->isEmpty() ? $checked : false)) checked @endif
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
</div>
{{--@include('components.forms.after')--}}
