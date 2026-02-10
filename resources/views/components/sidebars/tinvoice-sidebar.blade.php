
<x-template.sidebar-item :title="__('Dashboard')" :icon="'fa-desktop'" :link="url('tinvoice')" />

@hasanyrole('Developer|DETInvoiceAdmins|DETInvoiceUsers')
    <x-template.sidebar-parent-item :active="$active === 'invoices'" :title="__('Rechnungen')" :icon="'fa-cogs'">
        <x-template.sidebar-child-item :title="__('Gesamtliste')" :abbr="'K'" :link="route('tinvoice.invoices.list')" />
        <x-template.sidebar-child-item :title="__('Neue')" :abbr="'K'" :link="route('tinvoice.invoices.list', ['filter'=> 'new'])" />
        <x-template.sidebar-child-item :title="__('Abgelehnte')" :abbr="'K'" :link="route('tinvoice.invoices.list', ['filter'=> 'rejected'])" />
        <x-template.sidebar-child-item :title="__('Zum senden markiert')" :abbr="'K'" :link="route('tinvoice.invoices.list', ['filter'=> 'approved'])" />
        <x-template.sidebar-child-item :title="__('Gesendete')" :abbr="'K'" :link="route('tinvoice.invoices.list', ['filter'=> 'sent'])" />
        <x-template.sidebar-child-item :title="__('Übertragung bestätigt')" :abbr="'K'" :link="route('tinvoice.invoices.list', ['filter'=> 'transfer-confirmed'])" />
    </x-template.sidebar-parent-item>
@endhasanyrole

@hasanyrole('Developer|DETInvoiceAdmins|DETInvoiceUsers')
    <x-template.sidebar-parent-item :active="$active === 'system'" :title="__('System')" :icon="'fa-cogs'">
        <x-template.sidebar-child-item :title="__('Kundenkonfiguration')" :abbr="'K'" :link="route('tinvoice.configurations.index')" />
    </x-template.sidebar-parent-item>
@endhasanyrole
<x-template.sidebar-item :title="__('About')" :icon="'fa-info-circle'" :link="route('tinvoice.about')" />
