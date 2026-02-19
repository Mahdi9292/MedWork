<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

/**
 * Class PowerGridOrderableColumnsTrait
 *
 * Add column order functionality to Livewire Power Grid
 * Usage:
 * Return PG columns in function columns through function orderColumns() to get ordered columns
 *
 * @package App
 */
trait PowerGridOrderableColumnsTrait
{
    public string $orderableColumnsKey = 'medwork.powergrid.{tableName}.columns.order';

    public function getOrderableColumnsKey(): string
    {
        return str_replace('{tableName}', $this->tableName, $this->orderableColumnsKey);
    }

    public function orderColumns(array $columns): array
    {
        $orderableColumns = Auth::user()->settings()->get($this->getOrderableColumnsKey());

        if(!$orderableColumns){
            return $columns;
        }

        return $this->orderColumnsByGivenOrder($columns, $orderableColumns);
    }

    public function orderableColumns(): array
    {
        // getting the columns saved in user settings.
        $orderableColumns = Auth::user()->settings()->get($this->getOrderableColumnsKey());

        if(!$orderableColumns || !is_array(array_filter($orderableColumns))) {
            return $this->columns;
        }

        return $this->orderColumnsByGivenOrder($this->columns, $orderableColumns);
    }

    public function saveColumnsOrder(array $columns): void
    {
        $columns = array_map(fn($item) => str_replace("'", '', $item), $columns);
        Auth::user()->settings()->delete($this->getOrderableColumnsKey());
        Auth::user()->settings()->set($this->getOrderableColumnsKey(), $columns);
        parent::mount();
    }

    public function resetColumnsOrder(): void
    {
        Auth::user()->settings()->delete($this->getOrderableColumnsKey());
        parent::mount();
    }

    private function orderColumnsByGivenOrder(array $columns, array $fieldOrder): array
    {
        // Create a lookup map for the desired field order
        $orderMap = array_flip($fieldOrder);

        // Sort using the arrow function and spaceship operator
        usort(
            $columns,
            fn($a, $b) => ($orderMap[data_get($a, 'field')] ?? PHP_INT_MAX) <=> ($orderMap[data_get($b, 'field')] ?? PHP_INT_MAX)
        );

        return $columns;
    }
}
