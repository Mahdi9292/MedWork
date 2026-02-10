<nav aria-label="breadcrumb" class="d-none d-md-inline-block">
    <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
        <li class="breadcrumb-item"><a href="{{ url('/')  }}"><span class="fas fa-home"></span></a></li>
        @foreach ($links as $link)
            <li class="breadcrumb-item"><a href="{{ $link['url'] }}">{{ $link['key'] }}</a></li>
        @endforeach
        {{ $slot }}
        <li class="breadcrumb-item active" aria-current="page">{{ $activePage }}</li>
    </ol>
</nav>
