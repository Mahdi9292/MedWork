
<x-template.sidebar-item :title="__('Dashboard')" :icon="'fa-desktop'" :link="url('tcommission')" />

@canany([
    config('perm.tcommission.commission.view'),
    config('perm.tcommission.commission.calculate'),
])
    <x-template.sidebar-parent-item :active="$active === 'commission'" :title="__('Verkäufer')" :icon="'fa-euro-sign'">
        <x-template.sidebar-child-item :title="__('Commission')" :link="url('tcommission/commission')" :icon="'fa-coins'" :permission="config('perm.tcommission.commission.view')" />
        <x-template.sidebar-child-item :title="__('Berechnung')" :link="url('tcommission/commission/calculation')" :icon="'fa-calculator'" :permission="config('perm.tcommission.commission.calculate')" />
    </x-template.sidebar-parent-item>
@endcanany
@canany([
    config('perm.tcommission.saCommission.view'),
    config('perm.tcommission.saCommission.calculate'),
])

<x-template.sidebar-parent-item :active="$active === 'sacommission'" :title="__('Vertriebsassistenz')" :icon="'fa-euro-sign'">
    <x-template.sidebar-child-item :title="__('Commission')" :link="url('tcommission/sacommission')" :icon="'fa-coins'" :permission="config('perm.tcommission.saCommission.view')" />
    <x-template.sidebar-child-item :title="__('Berechnung')" :link="url('tcommission/sacommission/calculation')" :icon="'fa-calculator'" :permission="config('perm.tcommission.saCommission.calculate')" />
</x-template.sidebar-parent-item>
@endcanany

@canany([
    config('perm.tcommission.aeCommission.view'),
])
    <x-template.sidebar-parent-item :active="$active === 'aecommission'" :title="__('Vorschau')" :icon="'fa-chart-line'">
        <x-template.sidebar-child-item :title="__('Commission')" :link="route('tcommission.commission.preview')" :icon="'fa-coins'" :permission="config('perm.tcommission.aeCommission.view')" />
    </x-template.sidebar-parent-item>
@endcanany

@canany([
    config('perm.tcommission.salesman.view'),
    config('perm.tcommission.modelGroups.view'),
    config('perm.tcommission.models.view'),
    config('perm.tcommission.discountLevels.view'),
    config('perm.tcommission.splittingExceptions.view'),
])
    <x-template.sidebar-parent-item :active="$active === 'system'" :title="'System'" :icon="'fa-cogs'">
        <x-template.sidebar-child-item :title="__('Verkäufer')" :abbr="'V'" :link="route('tcommission.salesman.index')" :permission="config('perm.tcommission.salesman.view')" />
        <x-template.sidebar-child-item :title="__('Modellgruppe')" :abbr="'G'" :link="route('tcommission.modelgroups.index')" :permission="config('perm.tcommission.modelGroups.view')" />
        <x-template.sidebar-child-item :title="__('Modelle')" :abbr="'M'" :link="route('tcommission.models.index')" :permission="config('perm.tcommission.models.view')" />
        <x-template.sidebar-child-item :title="__('Discount Levels')" :abbr="'D'" :link="route('tcommission.discountlevels.index')" :permission="config('perm.tcommission.discountLevels.view')" />
        <x-template.sidebar-child-item :title="__('Splitting Exceptions')" :abbr="'S'" :link="route('tcommission.splittingexceptions.index')" :permission="config('perm.tcommission.splittingExceptions.view')" />

        <x-template.sidebar-child-item :title="__('Vertriebsassistenz')" :abbr="'V'" :link="route('tcommission.salesassistants.index')" :permission="config('perm.tcommission.salesAssistants.view')" />
        <x-template.sidebar-child-item :title="__('VA Provision')" :abbr="'V'" :link="route('tcommission.sacommissionlevels.index')" :permission="config('perm.tcommission.saCommissionLevels.view')" />
    </x-template.sidebar-parent-item>
@endcanany
<x-template.sidebar-item :title="__('About')" :icon="'fa-info-circle'" :link="route('tcommission.about')" />
