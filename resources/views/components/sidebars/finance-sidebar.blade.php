<x-template.sidebar-item :title="'Dashboard'" :icon="'fa-tachometer-alt'" :link="url('/finance')" />

@canany([
    config('perm.finance.invoice.view'),
])
<x-template.sidebar-parent-item :active="$active === 'accounting'" :title="'Buchhaltung'" :icon="'fa-file-invoice'">
    <x-template.sidebar-child-item :title="__('Rechnungen')" :abbr="'RE'" :link="route('finance.invoices.index')" :permission="config('perm.finance.invoice.view')" />
</x-template.sidebar-parent-item>
@endcanany

@canany([
    config('perm.finance.invoiceItemType.view'),
])
    <x-template.sidebar-parent-item :active="$active === 'system'" :title="'System'" :icon="'fa-cogs'">
        <x-template.sidebar-child-item :title="__('Leistungstyp')" :abbr="'T'" :link="route('finance.invoiceItemTypes.index')" :permission="config('perm.finance.invoiceItemType.view')" />
    </x-template.sidebar-parent-item>
@endcanany
