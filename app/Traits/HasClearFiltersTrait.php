<?php

namespace App\Traits;

use Livewire\Attributes\On;

/**
 * Class HasClearFiltersTrait
 * Only works with Livewire Powergrid.
 * used to clear search and filters on the powergrid.
 *
 * @package App
 */
trait HasClearFiltersTrait
{
    public function clearPowerGridFilters(): void
    {
        $this->clearAllFilters();
    }

    public function clearPowerGridSearch(): void
    {
        $this->search = '';
        $this->refresh();
    }

    #[On('pg:resetGrid-{tableName}')]
    public function resetPowerGrid(): void
    {
        $this->clearPowerGridFilters();
        $this->clearPowerGridSearch();
    }
}
