<x-template.sidebar-item :title="'Dashboard'" :icon="'fa-tachometer-alt'" :link="url('medical')" />

@canany([
    config('perm.medical.certificates.view'),
])
<x-template.sidebar-parent-item :active="$active === 'examinations'" :title="'Vorsorgen'" :icon="'fa-dolly'">
    <x-template.sidebar-child-item :title="__('Bescheinigungen')" :abbr="'BE'" :link="route('medical.certificates.index')" :permission="config('perm.medical.certificate.view')" />
</x-template.sidebar-parent-item>
@endcanany

@canany([
    config('perm.medical.activity.view'),
])
    <x-template.sidebar-parent-item :active="$active === 'system'" :title="'System'" :icon="'fa-cogs'">
        <x-template.sidebar-child-item :title="__('Arbeitgeber')" :abbr="'A'" :link="route('medical.employers.index')" :permission="config('perm.medical.employer.view')" />
        <x-template.sidebar-child-item :title="__('Tätigkeiten')" :abbr="'T'" :link="route('medical.activities.index')" :permission="config('perm.medical.activity.view')" />
    </x-template.sidebar-parent-item>
@endcanany
