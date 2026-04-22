<?php

namespace App\Policies\Finance;

use App\Models\Finance\InvoiceItemType;
use App\Models\User;

class InvoiceItemTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(config('perm.finance.invoiceItemType.view'));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, InvoiceItemType $invoiceItemType): bool
    {
        return $user->can(config('perm.finance.invoiceItemType.view'));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(config('perm.finance.invoiceItemType.create'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, InvoiceItemType $invoiceItemType): bool
    {
        return $user->can(config('perm.finance.invoiceItemType.update'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, InvoiceItemType $invoiceItemType): bool
    {
        return $user->can(config('perm.finance.invoiceItemType.delete'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, InvoiceItemType $invoiceItemType): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, InvoiceItemType $invoiceItemType): bool
    {
        return false;
    }
}
