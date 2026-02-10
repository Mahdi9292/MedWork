<table
    {{ $attributes->class(['table', 'table-hover', 'table-flush', 'table-bordered', 'jsDataTable' => $jsDataTable, 'w-100' => $width100]) }}
    id="{{ $id }}"
>
    @if($caption)
        <caption>{{ $caption }}</caption>
    @endif
    <thead class="thead-light">
        <tr>
            @foreach ($cols as $col)
                <th class="{!! $col['class'] ?? '' !!}">{{ $col['title'] }}</th>
            @endforeach
            {{ $columns ?? '' }}
        </tr>
    </thead>
    <tbody>
        {{ $body ?? '' }}
    </tbody>
    @if ($footer ?? null)
        <tfoot>
            {{ $footer ?? '' }}
        </tfoot>
    @endif
</table>
