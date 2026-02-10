<li {{ $attributes->class(['nav-item', 'active' => $active]) }}>
    <a href="{{ $link }}" class="nav-link" @if($target) target="{{ $target }}" @endif>
        @if($abbr)
            <span class="sidebar-text-contracted">{{ $abbr }}</span>
        @endif

        @if($icon)
            <span class="sidebar-icon"><span class="fas {{ $icon }}"></span></span>
        @endif

        <span class="sidebar-text">{{ $title }}</span>
    </a>
</li>
