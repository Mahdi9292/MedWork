@if($trailingAddon)
    <span class="input-group-text text-gray-600 input-trailing-container">{!! $trailingAddon !!}</span>
@elseif ($trailingIcon)
    {!! $trailingIcon !!}
@endif

@if($leadingAddon || $leadingIcon || $trailingAddon || $trailingIcon)
    </div>
@endif
