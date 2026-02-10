<x-template.sidebar-item :title="__('Dashboard')" :icon="'fa-desktop'" :link="url('ttime')" />

@if(Auth::user()->hasRole(config('tmhde.t_time.role_technician')))
    <x-template.sidebar-item :title="__('Monatsberichte')" :abbr="'MB'" :icon="'fa-calendar'"  :link="route('ttime.monthly_reports.index')" :permission="config('perm.ttime.monthlyReport.view')" />
    <x-template.sidebar-item :title="__('Spesen')" :abbr="'SP'" :icon="'fa-hand-holding-usd'" :link="route('ttime.expenses.index')" :permission="config('perm.ttime.expense.view')" />
@endif

@canany([
    config('perm.ttime.monthlyReport.viewBackoffice'),
    config('perm.ttime.monthlyReport.viewHR'),
])
    <x-template.sidebar-parent-item :active="$active === 'monthly_reports'" :title="__('Monatsberichte')" :icon="'fa-calendar'">
        <x-template.sidebar-child-item :title="__('Arbeitsvorrat (BO)')" :abbr="'BO'"  :link="route('ttime.monthly_reports.backoffices')" :permission="config('perm.ttime.monthlyReport.viewBackoffice')" />
        <x-template.sidebar-child-item :title="__('Arbeitsvorrat (HR)')" abbr="HR" :link="route('ttime.monthly_reports.hr')" :permission="config('perm.ttime.monthlyReport.viewHR')" />
    </x-template.sidebar-parent-item>
@endcanany

@canany([
    config('perm.ttime.expense.viewBacklog')
])
    <x-template.sidebar-parent-item :active="$active === 'expenses'" :title="__('Spesen')" :icon="'fa-hand-holding-usd'">
        <x-template.sidebar-child-item :title="__('Vorrat (Finance)')" :abbr="'AF'"  :link="route('ttime.expenses.backlog.index')" :permission="config('perm.ttime.expense.viewBacklog')" />
    </x-template.sidebar-parent-item>
@endcanany

@canany([
    config('perm.ttime.bookedHours.view'),
])
    <x-template.sidebar-item :title="__('Stundenbuchungen')" :icon="'fa-business-time'" :link="route('ttime.bookedHours')" :permission="config('perm.ttime.bookedHours.view')" />
@endcanany

@canany([
    config('perm.ttime.timeAccount.view'),
    config('perm.ttime.holiday.view'),
    config('perm.ttime.worker.view'),
    config('perm.ttime.backOfficer.view'),
    config('perm.ttime.expenseAllowance.view'),
    config('perm.ttime.workCouncilMember.view'),
])
    <x-template.sidebar-parent-item :active="$active === 'administration'" :title="__('Administration')" :icon="'fa-cogs'">
        <x-template.sidebar-child-item :title="__('AZ-Konten')" :abbr="'AK'"  :link="route('ttime.timeAccounts.index')" :permission="config('perm.ttime.timeAccount.view')" />
        <x-template.sidebar-child-item :title="__('Kostenstelle')" :abbr="'AK'"  :link="route('ttime.costCenters.index')" :permission="config('perm.ttime.costCenter.view')" />
        <x-template.sidebar-child-item :title="__('Feiertage')" :abbr="'FT'"  :link="route('ttime.holidays.index')" :permission="config('perm.ttime.holiday.view')" />
        <x-template.sidebar-child-item :title="__('Techniker Verwaltung')" :abbr="'TV'"  :link="route('ttime.workers.index')" :permission="config('perm.ttime.worker.view')" />
        <x-template.sidebar-child-item :title="__('Backoffice Verwaltung')" :abbr="'BV'"  :link="route('ttime.backOfficers.index')" :permission="config('perm.ttime.backOfficer.view')" />
        <x-template.sidebar-child-item :title="__('BR Verwaltung')" :abbr="'BRV'"  :link="route('ttime.workCouncilMembers.index')" :permission="config('perm.ttime.workCouncilMember.view')" />
        <x-template.sidebar-child-item :title="__('Spesenverwaltung')" :abbr="'SV'"  :link="route('ttime.expenseAllowances.index')" :permission="config('perm.ttime.expenseAllowance.view')" />
    </x-template.sidebar-parent-item>
@endcanany

