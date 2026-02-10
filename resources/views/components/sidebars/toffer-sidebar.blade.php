
<x-template.sidebar-item :title="__('Dashboard')" :icon="'fa-desktop'" :link="url('toffer')" />

@canany([
    config('perm.toffer.offer.view'),
])
    <x-template.sidebar-parent-item :active="$active === 'offers'" :title="'Angebote'" :icon="'fa-handshake'">
        <x-template.sidebar-child-item :title="__('Angebotsliste')" :abbr="'AL'"  :link="route('toffer.offers.index')" :permission="config('perm.toffer.offer.view')" />
    </x-template.sidebar-parent-item>
@endcanany

@canany([
    config('perm.toffer.models.view'),
    ])
    <x-template.sidebar-parent-item :active="$active === 'system'" :title="'System'" :icon="'fa-cogs'">
        <x-template.sidebar-child-item :title="__('Modelle')" :abbr="'K'"  :link="route('toffer.models.index')" :permission="config('perm.toffer.models.view')" />
    </x-template.sidebar-parent-item>
@endcanany
<x-template.sidebar-item :title="__('About')" :icon="'fa-info-circle'" :link="route('toffer.about')" />
