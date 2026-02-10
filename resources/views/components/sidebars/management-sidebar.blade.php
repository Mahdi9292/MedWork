
<x-template.sidebar-item :title="__('Dashboard')" :icon="'fa-desktop'" :link="url('management')" />

@canany([
    config('perm.management.forkCarriages.view'),
    config('perm.management.modelFamilies.view'),
    config('perm.management.vehicles.view'),
])
    <x-template.sidebar-parent-item :active="$active === 'vehicle'" :title="__('Fahrzeuge')" :icon="'fa-truck'">

        <x-template.sidebar-child-item :title="__('Gabelträger')" :abbr="'F'" :link="route('management.forkcarriages.index')" :permission="config('perm.management.forkCarriages.view')" />
        <x-template.sidebar-child-item :title="__('Modellfamilien')" :abbr="'F'" :link="route('management.modelfamilies.index')" :permission="config('perm.management.modelFamilies.view')" />
        <x-template.sidebar-child-item :title="__('Fahrzeuge')" :abbr="'G'" :link="route('management.vehicles.index')" :permission="config('perm.management.vehicles.view')" />
    </x-template.sidebar-parent-item>
@endcanany
