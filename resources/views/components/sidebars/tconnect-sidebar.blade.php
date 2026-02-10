
<x-template.sidebar-item :title="__('Dashboard')" :icon="'fa-desktop'" :link="url('tconnect')" />

@canany([
    config('perm.tconnect.forkLift.view'),
    config('perm.tconnect.liftFinder.view'),
    config('perm.tconnect.itl.view'),
    config('perm.tconnect.orisa.view'),
    config('perm.tconnect.ffb.view'),
])
    <x-template.sidebar-parent-item :active="$active === 'feeds'" :title="'XML Feed'" :icon="'fa-file-export'">
        <x-template.sidebar-child-item :title="__('ForkLift')" :abbr="'FL'"  :link="route('tconnect.forkLift.index')" :permission="config('perm.tconnect.forkLift.view')" />
        <x-template.sidebar-child-item :title="__('LiftFinder')" :abbr="'LF'"  :link="route('tconnect.liftFinder.index')" :permission="config('perm.tconnect.liftFinder.view')" />
        <x-template.sidebar-child-item :title="__('ITL')" :abbr="'IT'"  :link="route('tconnect.itl.index')" :permission="config('perm.tconnect.itl.view')" />
        <x-template.sidebar-child-item :title="__('Orisa')" :abbr="'OR'"  :link="route('tconnect.orisa.index')" :permission="config('perm.tconnect.orisa.view')" />
        <x-template.sidebar-child-item :title="__('FFB')" :abbr="'FF'"  :link="route('tconnect.ffb.index')" :permission="config('perm.tconnect.ffb.view')" />
    </x-template.sidebar-parent-item>
@endcanany

@canany([
    config('perm.tconnect.platforms.view'),
    config('perm.tconnect.logs.view'),
    ])
    <x-template.sidebar-parent-item :active="$active === 'system'" :title="'System'" :icon="'fa-cogs'">
        <x-template.sidebar-child-item :title="__('Plattformen')" :abbr="'P'"  :link="route('tconnect.platforms.index')" :permission="config('perm.tconnect.platforms.view')" />
        <x-template.sidebar-child-item :title="__('Logs')" :abbr="'L'"  :link="route('tconnect.logs.index')" :permission="config('perm.tconnect.logs.view')" />
    </x-template.sidebar-parent-item>
@endcanany
<x-template.sidebar-item :title="__('About')" :icon="'fa-info-circle'" :link="route('tconnect.about')" />
