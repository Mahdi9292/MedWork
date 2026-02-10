<x-template.sidebar-item :title="__('Dashboard')" :icon="'fa-desktop'" :link="url('tservicestock')" />
<x-template.sidebar-item :title="__('Bestand Umschlag')" :icon="'fa-envelope'" :link="url('tservicestock/stock')" />

<x-template.sidebar-parent-item :active="$active === 'system'" :title="'System'" :icon="'fa-cogs'">
    <x-template.sidebar-child-item :title="__('Lagerort E-Mail')" :abbr="'L'" :link="route('tservicestock.storagesiteemails.index')" />
</x-template.sidebar-parent-item>

<x-template.sidebar-item :title="__('About')" :icon="'fa-info-circle'" :link="route('tservicestock.about')" />
