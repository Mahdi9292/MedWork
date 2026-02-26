<x-template.sidebar-item :title="'Dashboard'" :icon="'fa-tachometer-alt'" :link="url('/finance')" />

@canany([
    config('perm.finance.invoice.view'),
])
<x-template.sidebar-parent-item :active="$active === 'invoices'" :title="'Rechnungen'" :icon="'fa-dolly'">
    <x-template.sidebar-child-item :title="__('Rechnungen')" :abbr="'RE'" :link="route('finance.invoices.index')" :permission="config('perm.finance.invoice.view')" />
</x-template.sidebar-parent-item>
@endcanany
