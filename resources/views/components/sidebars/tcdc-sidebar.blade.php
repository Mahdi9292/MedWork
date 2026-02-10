
<x-template.sidebar-item :title="__('Dashboard')" :icon="'fa-desktop'" :link="url('tcdc')" />

@canany([
    config('perm.tcdc.newTicket.view'),
    config('perm.tcdc.modificationTicket.view'),
])
    <x-template.sidebar-parent-item :active="$active === 'tickets'" :title="'Tickets'" :icon="'fa-ticket'">
        <x-template.sidebar-child-item :title="__('Neuanlage')" :abbr="'NA'"  :link="route('tcdc.newTickets.index')" :permission="config('perm.tcdc.newTicket.view')" />
        <x-template.sidebar-child-item :title="__('Änderungen')" :abbr="'ÄN'"  :link="route('tcdc.modificationTickets.index')" :permission="config('perm.tcdc.modificationTicket.view')" />
    </x-template.sidebar-parent-item>
@endcanany


@canany([
    config('perm.tcdc.iaNumber.view'),
    config('perm.tcdc.ekaCustomerGroup.view'),
    config('perm.tcdc.nkaCustomerGroup.view'),
    config('perm.tcdc.feldCustomerGroup.view'),
    config('perm.tcdc.dealerCustomerGroup.view'),
    config('perm.tcdc.salesman.view'),
    config('perm.tcdc.kaManager.view'),
    config('perm.tcdc.salesManager.view'),
    config('perm.tcdc.dealerSupervisor.view'),
    config('perm.tcdc.maintenanceLocation.view'),
])
    <x-template.sidebar-parent-item :active="$active === 'system'" :title="'System'" :icon="'fa-cogs'">
        <x-template.sidebar-child-item :title="__('IA Nummer')" :abbr="'Nr'" :link="route('tcdc.iaNumbers.index')" :permission="config('perm.tcdc.iaNumber.view')" />
        <x-template.sidebar-child-item :title="__('EKA Kundengruppe')" :abbr="'KG IA'" :link="route('tcdc.ekaCustomerGroups.index')" :permission="config('perm.tcdc.ekaCustomerGroup.view')" />
        <x-template.sidebar-child-item :title="__('NKA Kundengruppe')" :abbr="'T'" :link="route('tcdc.nkaCustomerGroups.index')" :permission="config('perm.tcdc.nkaCustomerGroup.view')" />
        <x-template.sidebar-child-item :title="__('Feld Kundengruppe')" :abbr="'T'" :link="route('tcdc.feldCustomerGroups.index')" :permission="config('perm.tcdc.feldCustomerGroup.view')" />
        <x-template.sidebar-child-item :title="__('Händler Kundengruppe')" :abbr="'T'" :tool-tip="__('Kundengruppen Händler')" :link="route('tcdc.dealerCustomerGroups.index')" :permission="config('perm.tcdc.dealerCustomerGroup.view')" />
            <x-template.sidebar-child-item :title="__('Feldverkäufer ID')" :abbr="'T'" :link="route('tcdc.salesmen.index')" :permission="config('perm.tcdc.salesman.view')" />
        <x-template.sidebar-child-item :title="__('KA Manager ID')" :abbr="'T'" :link="route('tcdc.kaManagers.index')" :permission="config('perm.tcdc.kaManager.view')" />
        <x-template.sidebar-child-item :title="__('Verkaufsleiter ID')" :abbr="'T'" :link="route('tcdc.salesManagers.index')" :permission="config('perm.tcdc.salesManager.view')" />
        <x-template.sidebar-child-item :title="__('Händlerbetreuer ID')" :abbr="'T'" :link="route('tcdc.dealerSupervisors.index')" :permission="config('perm.tcdc.dealerSupervisor.view')" />
        <x-template.sidebar-child-item :title="__('Wartungsverantwortlicher')" :abbr="'T'" :link="route('tcdc.maintenanceLocations.index')" :permission="config('perm.tcdc.maintenanceLocation.view')" />
    </x-template.sidebar-parent-item>
@endcanany

<x-template.sidebar-item :title="__('About')" :icon="'fa-circle-info'" :link="route('tcdc.about')" />

