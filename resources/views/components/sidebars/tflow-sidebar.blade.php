
<x-template.sidebar-item :title="__('Dashboard')" :icon="'fa-desktop'" :link="url('tflow')" />

@canany([
    config('perm.tflow.invoice.view'),
    config('perm.tflow.invoiceLine.view'),
    config('perm.tflow.invoiceLine.viewDamaged'),
    config('perm.tflow.invoiceLine.viewCancelled'),
])
    <x-template.sidebar-parent-item :active="$active === 'orders'" :title="'Aufträge'" :icon="'fa-dolly'">
        <x-template.sidebar-child-item :title="__('Auftragliste')" :abbr="'A'"  :link="route('tflow.invoices.index')" :permission="config('perm.tflow.invoice.view')" />
        <x-template.sidebar-child-item :title="__('Stornierte')" abbr="S" :link="route('tflow.lines.cancelled')" :permission="config('perm.tflow.invoiceLine.viewCancelled')" />
        <x-template.sidebar-child-item :title="__('Auftrag-Geräte')" :abbr="'AG'"  :link="route('tflow.lines.index')" :permission="config('perm.tflow.invoiceLine.view')" />
        <x-template.sidebar-child-item :title="__('Gewaltschäden')" :abbr="'G'"  :link="route('tflow.lines.damaged')" :permission="config('perm.tflow.invoiceLine.viewDamaged')" />
        <x-template.sidebar-child-item :title="__('Terminänderungen')" :abbr="'T'"  :link="route('tflow.invoices.transportDateChanges')" :permission="config('perm.tflow.invoice.viewTransportDateChanges')" />
    </x-template.sidebar-parent-item>
@endcanany

@canany([
    config('perm.tflow.invoiceLine.viewInternalLogistics'),
    config('perm.tflow.invoiceLine.viewDispoWorkshop'),
    config('perm.tflow.invoiceLine.viewWorkshop'),
])
    <x-template.sidebar-parent-item :active="$active === 'workshop'" :title="'Geräteauftrag'" :icon="'fa-dolly-flatbed'">
        <x-template.sidebar-child-item :title="__('Int. Log Übersicht')" :abbr="'I'"  :link="route('tflow.lines.internalLogistics')" :permission="config('perm.tflow.invoiceLine.viewInternalLogistics')" />
        <x-template.sidebar-child-item :title="__('Dispo Werkstatt')" :abbr="'D'"  :link="route('tflow.lines.dispoWorkshop')" :permission="config('perm.tflow.invoiceLine.viewDispoWorkshop')" />
        <x-template.sidebar-child-item :title="__('Werkstattübersicht')" :abbr="'W'"  :link="route('tflow.lines.workshop')" :permission="config('perm.tflow.invoiceLine.viewWorkshop')" />
    </x-template.sidebar-parent-item>
@endcanany

@canany([
    config('perm.tflow.carriers.view'),
    config('perm.tflow.additionalWork.view'),
    config('perm.tflow.technicians.view'),
    config('perm.tflow.deliveryStatus.view'),
    config('perm.tflow.workshops.view'),
    config('perm.tflow.info.view'),
    config('perm.tflow.backOfficeEmails.view'),
    config('perm.tflow.costCenter.view'),
    config('perm.tflow.contractType.view'),
    ])
    <x-template.sidebar-parent-item :active="$active === 'system'" :title="'System'" :icon="'fa-cogs'">
        <x-template.sidebar-child-item :title="__('Kunde')" :abbr="'K'"  :link="route('tflow.customers.index')" :permission="config('perm.tflow.customers.view')" />
        <x-template.sidebar-child-item :title="__('Geräte')" :abbr="'G'"  :link="route('tflow.lifter.index')" :permission="config('perm.tflow.lifter.view')" />
        <x-template.sidebar-child-item :title="__('Spedition')" :abbr="'S'" :link="route('tflow.carrier.index')" :permission="config('perm.tflow.carriers.view')" />
        <x-template.sidebar-child-item :title="__('Zusätzliche Arbeit')" :abbr="'Z'" :link="route('tflow.additionalwork.index')" :permission="config('perm.tflow.additionalWork.view')" />
        <x-template.sidebar-child-item :title="__('Logistiker & Techniker')" :abbr="'LT'"  :link="route('tflow.technician.index')" :permission="config('perm.tflow.technicians.view')" />
        <x-template.sidebar-child-item :title="__('Auftragstatus')" :abbr="'AS'"  :link="route('tflow.deliverystatuses.index')" :permission="config('perm.tflow.deliveryStatus.view')" />
        <x-template.sidebar-child-item :title="__('Werkstätten')" :abbr="'W'" :link="route('tflow.workshop.index')" :permission="config('perm.tflow.workshops.view')" />
        <x-template.sidebar-child-item :title="__('Info Leiste')" :abbr="'I'" :link="route('tflow.info.index')" :permission="config('perm.tflow.info.view')" />
        <x-template.sidebar-child-item :title="__('Back Office Email')" :abbr="'B'" :link="route('tflow.backofficeemail.index')" :permission="config('perm.tflow.backOfficeEmails.view')" />
        <x-template.sidebar-child-item :title="__('Kostenstelle')" :abbr="'T'" :link="route('tflow.costcenters.index')" :permission="config('perm.tflow.costCenter.view')" />
        <x-template.sidebar-child-item :title="__('Vertragsart')" :abbr="'V'" :link="route('tflow.contracttypes.index')" :permission="config('perm.tflow.contractType.view')" />
        <x-template.sidebar-child-item :title="__('Modellkategorien')" :abbr="'V'" :link="route('tflow.modelCategories.index')" :permission="config('perm.tflow.modelCategory.view')" />
    </x-template.sidebar-parent-item>
@endcanany
<x-template.sidebar-item :title="__('About')" :icon="'fa-info-circle'" :link="route('tflow.about')" />
