<div>
    @if ($override)<del>@endif

        @if($type == 'currency')
            {{ formatNumber($text) }}
        @else
            {{ $text }}
        @endif

        {{ $append }}

    @if ($override)</del>@endif
</div>
