<x-template.sidebar-item :title="__('Dashboard')" :icon="'fa-desktop'" :link="url('tanalysis')" />

<x-template.sidebar-parent-item :active="$active === 'projects'" :title="'Projects'" :icon="'fa-project-diagram'">

    <x-template.sidebar-child-item :title="__('Neues ProjeKt')" :abbr="'N'" :link="route('tanalysis.projects.create')" />
    <x-template.sidebar-child-item :title="__('Einsatzanalyse')" :abbr="'E'" :link="route('tanalysis.projects.deployments')" />
    <x-template.sidebar-child-item :title="__('Site Survey')" :abbr="'S'" :link="route('tanalysis.projects.siteSurveys')" />

</x-template.sidebar-parent-item>
<x-template.sidebar-item :title="__('About')" :icon="'fa-info-circle'" :link="route('tanalysis.about')" />
