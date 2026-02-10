
<x-template.sidebar-item :title="__('Dashboard')" :icon="'fa-desktop'" :link="url('administration')" />

@canany([
    config('perm.administration.roles.view'),
    config('perm.administration.permissions.view'),
    config('perm.administration.authScopes.view'),
])
    <x-template.sidebar-parent-item :active="$active === 'authorization'" :title="__('Permissions')" :icon="'fa-user-lock'">

        <x-template.sidebar-child-item :title="__('AuthScopes')" :abbr="'A'" :link="route('administration.authscopes.index')" :permission="config('perm.administration.authScopes.view')" />
        <x-template.sidebar-child-item :title="__('Berechtigungen')" :abbr="'B'" :link="route('administration.permissions.index')" :permission="config('perm.administration.permissions.view')" />
        <x-template.sidebar-child-item :title="__('Rollen')" :abbr="'R'" :link="route('administration.roles.index')" :permission="config('perm.administration.roles.view')" />

    </x-template.sidebar-parent-item>
@endcanany

@canany([
    config('perm.administration.branches.view'),
    config('perm.administration.regions.view'),
])
    <x-template.sidebar-parent-item :active="$active === 'system'" :title="__('System')" :icon="'fa-cogs'">

        <x-template.sidebar-child-item :title="__('Benutzer')" :abbr="'B'" :link="route('administration.users.index')" />
        <x-template.sidebar-child-item :title="__('Niederlassung')" :abbr="'V'" :link="route('administration.branches.index')" :permission="config('perm.administration.branches.view')" />
        <x-template.sidebar-child-item :title="__('Region')" :abbr="'G'" :link="route('administration.regions.index')" :permission="config('perm.administration.regions.view')" />
    </x-template.sidebar-parent-item>
@endcanany
