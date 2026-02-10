<li {{ $attributes->class(['nav-item', 'sub-active' => $active, 'with-icon' => $icon]) }}>
    <a href="{{ $link }}" class="nav-link" @if($target) target="{{ $target }}" @endif title="{{ $toolTip }}">
        @if($abbr)
            <span class="sidebar-text-contracted {{ $active ? 'ms-n2': ''  }}">
                @if($active)
                    <span class="icon-badge-active-sidebar-contracted rounded-circle tmh-bg-white"></span>
                @endif
                {{ $abbr }}
            </span>
        @endif

        @if($icon)
            @if($active)
                <span class="icon-badge-active-sidebar-contracted rounded-circle tmh-bg-white"></span>
            @endif
            <span class="sidebar-icon"><span class="fas {{ $icon }}"></span></span>
        @endif

        <span class="sidebar-text {{ $active ? 'ms-n2-5': ''  }}">
            @if($active)
                <span class="icon-badge-active-sidebar rounded-circle tmh-bg-white "></span>
            @endif
            {{ $title }}
        </span>
    </a>
</li>
