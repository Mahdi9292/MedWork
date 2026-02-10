
<x-template.sidebar-item :title="__('Dashboard')" :icon="'fa-desktop'" :link="url('trequest')" />

@canany([
    config('perm.trequest.inquiry.view'),
])
<x-template.sidebar-parent-item :active="$active === 'inquiry'" :title="__('Anfragen')" :icon="'fa-broadcast-tower'">
    <x-template.sidebar-child-item :title="__('Anfrageliste')" :abbr="'Anfr.'" :link="route('trequest.inquiries.index')" :permission="config('perm.trequest.inquiry.view')" :tool-tip="__('regional Buisness Solution Teams')" />
</x-template.sidebar-parent-item>
@endcanany

@canany([
    config('perm.trequest.inquiry.view'),
])
<x-template.sidebar-parent-item :active="$active === 'evaluation'" :title="__('Auswertung')" :icon="'fa-chart-bar'">
    <x-template.sidebar-child-item :title="__('Auswertung')" :abbr="'R'" :link="route('trequest.lines.index')" :permission="config('perm.trequest.inquiry.view')" />
</x-template.sidebar-parent-item>
@endcanany


@canany([
    config('perm.trequest.regionalBSTeam.view'),
    config('perm.trequest.lineAttachment.view'),
])
<x-template.sidebar-parent-item :active="$active === 'system'" :title="__('System')" :icon="'fa-cogs'">
    <x-template.sidebar-child-item :title="__('regional BS Teams')" :abbr="'R'" :link="route('trequest.regionalbsteam.index')" :permission="config('perm.trequest.regionalBSTeam.view')" :tool-tip="__('regional Buisness Solution Teams')" />
    <x-template.sidebar-child-item :title="__('Anbaugeräte')" :abbr="'A'" :link="route('trequest.lineAttachment.index')" :permission="config('perm.trequest.lineAttachment.view')"  />
</x-template.sidebar-parent-item>
@endcanany
<x-template.sidebar-item :title="__('About')" :icon="'fa-info-circle'" :link="route('trequest.about')" />
