<x-template.sidebar-item :title="'Dashboard'" :icon="'fa-tachometer-alt'" :link="url('orderbook')" />

@canany([
    config('perm.orderbook.orders.view'),
    config('perm.orderbook.regions.view'),
    config('perm.orderbook.isite.view'),
    config('perm.orderbook.cfOrders.view'),
    config('perm.orderbook.dealerOrders.view'),
    config('perm.orderbook.serviceManagerOrders.view'),
])
<x-template.sidebar-parent-item :active="$active === 'orders'" :title="'Aufträge'" :icon="'fa-dolly'">
    <x-template.sidebar-child-item :title="__('Neugeräte')" :abbr="'N'" :link="route('orderbook.orders.index')" :permission="config('perm.orderbook.orders.view')" />
    <x-template.sidebar-child-item :title="__('Region')" :abbr="'R'" :link="route('orderbook.regions.index')" :permission="config('perm.orderbook.regions.view')" />
    <x-template.sidebar-child-item :title="__('I_Site')" :abbr="'I'" :link="route('orderbook.isite.index')" :permission="config('perm.orderbook.isite.view')" />
    <x-template.sidebar-child-item :title="__('CF-Aufträge')" :abbr="'C'" :link="route('orderbook.cfpositions.index')" :permission="config('perm.orderbook.cfOrders.view')" />
    <x-template.sidebar-child-item :title="__('Händler-Aufträge')" :abbr="'H'" :link="route('orderbook.dealers.index')" :permission="config('perm.orderbook.dealerOrders.view')" />
    <x-template.sidebar-child-item :title="__('SL-Aufträge')" :abbr="'SL'" :link="route('orderbook.serviceManagerOrders.index')" :permission="config('perm.orderbook.serviceManagerOrders.view')" />
</x-template.sidebar-parent-item>
@endcanany

@canany([
    config('perm.orderbook.ltrOrders.view'),
])
<x-template.sidebar-parent-item :active="$active === 'ltr'" :title="'LTR'" :icon="'fa-truck'">
    <x-template.sidebar-child-item :title="__('LTR-Aufträge')" :abbr="'L'" :link="route('orderbook.ltr.orders.index')" :permission="config('perm.orderbook.ltrOrders.view')" />
</x-template.sidebar-parent-item>
@endcanany

<x-template.sidebar-item :active="$active === 'salesman'" :title="__('Verkäufer')" :icon="'fa-users'" :link="route('orderbook.salesmen.index')" :permission="config('perm.orderbook.orders.view')" />

@canany([
    config('perm.orderbook.teams.view'),
    config('perm.orderbook.responsibles.view'),
    config('perm.orderbook.serviceManagers.view'),
    config('perm.orderbook.serviceManagerZones.view'),
])
<x-template.sidebar-parent-item :active="$active === 'system'" :title="'System'" :icon="'fa-cogs'">
    <x-template.sidebar-child-item :title="__('Teams')" :abbr="'T'" :link="route('orderbook.teams.index')" :permission="config('perm.orderbook.teams.view')" />
    <x-template.sidebar-child-item :title="__('Verantwortlicher')" :abbr="'V'" :link="route('orderbook.responsibles.index')" :permission="config('perm.orderbook.responsibles.view')" />
    <x-template.sidebar-child-item :title="__('Service Leiter')" :abbr="'SL'" :link="route('orderbook.serviceManagers.index')" :permission="config('perm.orderbook.serviceManagers.view')" />
    <x-template.sidebar-child-item :title="__('Service Leiter Ort')" :abbr="'SLO'" :link="route('orderbook.serviceManagerZones.index')" :permission="config('perm.orderbook.serviceManagerZones.view')" />
</x-template.sidebar-parent-item>
@endcanany
<x-template.sidebar-item :title="__('About')" :icon="'fa-info-circle'" :link="route('orderbook.about')" />
