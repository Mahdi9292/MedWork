<li {{ $attributes->class(['nav-item', 'active' => $active]) }}>
    <span class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#submenu-{{ $id }}">
      <span>
       @if($icon)
           <span class="sidebar-icon"><span class="fas {{ $icon }}"></span></span>
       @endif
        <span class="sidebar-text">{{ $title }}</span>
      </span>
      <span class="link-arrow"><span class="fas fa-chevron-right"></span></span>
    </span>
    <div class="multi-level collapse {{ ($active ?? false) ? 'show': ''  }}" role="list" id="submenu-{{ $id }}" aria-expanded="false">
        <ul class="flex-column nav">
            {{ $slot }}
        </ul>
    </div>
</li>
