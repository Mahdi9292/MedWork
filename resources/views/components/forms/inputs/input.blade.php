@include('components.forms.before')
@include('components.forms.leading-addons')

    <input
        name="{{ $name }}"
        type="{{ $type }}"
        id="{{ $id }}"
        {{ $disableAutofill ? 'autocomplete=nope' : 'autocomplete=off' }}
        {{ $attributes->merge(['class' => $inputClass()]) }}
        @if(!is_null($value))value="{{ $value }}"@endif

        @if ($hasErrorsAndShow($name))
            aria-invalid="true"

            @if (! $attributes->offsetExists('aria-describedby'))
            aria-describedby="{{ $id }}-error"
            @endif
        @endif
        {{ ($required ?? false) ? 'required' : '' }}
        @if($dataList && $dataList->count() > 0 && !$dataListMulti)list="list_{{ $id }}"@endif
        @if($dataList && $dataList->count() > 0 && $dataListMulti)
            data-multiple
            data-list="{{ $dataList->implode(', ') }}"
        @endif
    />

    @if($dataList && $dataList->count() > 0 && !$dataListMulti)
        <datalist id="list_{{ $id }}">
            @foreach($dataList as $listItem)
                <option>{{ $listItem }}</option>
            @endforeach
        </datalist>
    @endif

    @include('components.forms.trailing-addons')

    @if ($fieldInfo)
        <div class="font-small text-muted ms-2">
            {{ $fieldInfo }}
        </div>
    @endif

    @if ($hasErrorsAndShow($name))
        @error($name)
            <x-form.error :field="$name" />
        @enderror
    @endif
    <!-- <div class="invalid-feedback">Dies ist ein Pflichtfeld</div> -->
@include('components.forms.after')
