<x-template.sidebar-item :title="'Dashboard'" :icon="'fa-tachometer-alt'" :link="url('/dashboard')" />

@canany([
    config('perm.invoice.view'),

])
<x-template.sidebar-parent-item :active="$active === 'invoices'" :title="'Aufträge'" :icon="'fa-dolly'">
    <x-template.sidebar-child-item :title="__('Rechnungen')" :abbr="'RE'" :link="route('invoices.index')" :permission="config('perm.invoice.view')" />
</x-template.sidebar-parent-item>
@endcanany

<x-template.sidebar-item :title="__('About')" :icon="'fa-info-circle'" :link="route('home')" />
