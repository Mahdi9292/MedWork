<x-template.sidebar-item :active="$active === 'warranty' ?: false" :title="'Dashboard'" :icon="'fa-tachometer-alt'" :link="url('warranty')" />

@hasanyrole('Developer|de_Warranty_PRD_Admin|de_Warranty_PRD_Azubi|de_Warranty_PRD_Haendler')
    <x-template.sidebar-parent-item :active="in_array($active, ['inputclaims', 'outputclaims'])" :title="'Antrag'" :icon="'fa-file-contract'">
        @hasrole('Developer|de_Warranty_PRD_Admin|de_Warranty_PRD_Azubi|de_Warranty_PRD_Haendler')
            <x-template.sidebar-child-item :title="__('Händler Antragsliste')" :abbr="'H'" :link="url('warranty/inputclaims')" />
        @endhasanyrole
        @hasrole('Developer|de_Warranty_PRD_Admin|de_Warranty_PRD_Azubi|de_Warranty_PRD_Haendler')
            <x-template.sidebar-child-item :title="__('Händler Garantieantrag')" :abbr="'G'" :link="url('warranty/inputclaims/create')" />
        @endhasanyrole
        @hasanyrole('Developer|de_Warranty_PRD_Admin|de_Warranty_PRD_Azubi')
            <x-template.sidebar-child-item :title="__('TMHDE Antragsliste')" :abbr="'T'" :link="url('warranty/outputclaims')" />
        @endhasanyrole
    </x-template.sidebar-parent-item>
@endhasanyrole

@hasanyrole('Developer|de_Warranty_PRD_Admin|de_Warranty_PRD_Azubi')
    <x-template.sidebar-parent-item :active="in_array($active, ['vehicles', 'models'])" :title="'Fahrzeug'" :icon="'fa-dolly'">
        <x-template.sidebar-child-item :title="__('Fahrzeug anlegen')" :abbr="'F'" :link="url('warranty/vehicles/create')" />
        <x-template.sidebar-child-item :title="__('Fahrzeugliste')" :abbr="'F'" :link="url('warranty/vehicles')" />
        <x-template.sidebar-child-item :title="__('Modell anlegen')" :abbr="'M'" :link="url('warranty/models/create')" />
        <x-template.sidebar-child-item :title="__('Modellliste')" :abbr="'M'" :link="url('warranty/models')" />
    </x-template.sidebar-parent-item>
@endhasanyrole

@hasanyrole('Developer|de_Warranty_PRD_Admin|de_Warranty_PRD_Azubi')
    <x-template.sidebar-parent-item :active="in_array($active, ['campaigns', 'dealers', 'servicemanagers', 'masttypes', 'hourlyrates', 'splittingtypes'])" :title="'Stammdaten'" :icon="'fa-info-circle'">
        <x-template.sidebar-child-item :title="__('Kampagnen')" :abbr="'K'" :link="url('warranty/campaigns')" />
        <x-template.sidebar-child-item :title="__('Händler')" :abbr="'H'" :link="url('warranty/dealers')" />
        <x-template.sidebar-child-item :title="__('Techniker')" :abbr="'T'" :link="url('warranty/servicemanagers')" />
        <x-template.sidebar-child-item :title="__('Masttypen')" :abbr="'M'" :link="url('warranty/masttypes')" />
        <x-template.sidebar-child-item :title="__('Stundensätze')" :abbr="'S'" :link="url('warranty/hourlyrates')" />
        <x-template.sidebar-child-item :title="__('Aufsplittung')" :abbr="'A'" :link="url('warranty/splittingtypes')" />
    </x-template.sidebar-parent-item>
@endhasanyrole

@hasanyrole('Developer|de_Warranty_PRD_Admin|de_Warranty_PRD_Azubi')
    <x-template.sidebar-parent-item :active="$active === 'evaluations' ?: false" :title="'Auswertung'" :icon="'fa-chart-line'">
        <x-template.sidebar-child-item :title="__('Kampagnen')" :abbr="'K'" :link="url('warranty/evaluations/campaigns')" />
    </x-template.sidebar-parent-item>
@endhasanyrole

@hasanyrole('Developer|de_Warranty_PRD_Admin|de_Warranty_PRD_Azubi|de_Warranty_PRD_Haendler')
    <x-template.sidebar-parent-item :active="$active === 'inputorders' ?: false" :title="'Bestellung'" :icon="'fa-truck-ramp-box'">
        <x-template.sidebar-child-item :title="__('Meine Bestellungen')" :abbr="'M'" :link="url('warranty/inputorders')" />
    </x-template.sidebar-parent-item>
@endhasanyrole

@hasanyrole('Developer|de_Warranty_PRD_Admin|de_Warranty_PRD_Azubi|de_Warranty_PRD_Haendler')
    <x-template.sidebar-parent-item :active="$active === 'deliverynotes' ?: false" :title="'Rücksendung'" :icon="'fa-truck'">
        <x-template.sidebar-child-item :title="__('Neue Rücksendung')" :abbr="'N'" :link="url('warranty/deliverynotes/create')" />
        <x-template.sidebar-child-item :title="__('Meine Rücksendungen')" :abbr="'M'" :link="url('warranty/deliverynotes')" />
    </x-template.sidebar-parent-item>
@endhasanyrole
<x-template.sidebar-item :title="__('About')" :icon="'fa-info-circle'" :link="route('warranty.about')" />
