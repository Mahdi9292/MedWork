<?php

namespace App\Policies\Medical;

use App\Models\Medical\PreventionType;
use App\Models\User;

class PreventionTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(config('perm.medical.preventionType.view'));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PreventionType $preventionType): bool
    {
        return $user->can(config('perm.medical.preventionType.view'));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(config('perm.medical.preventionType.create'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PreventionType $preventionType): bool
    {
        return $user->can(config('perm.medical.preventionType.update'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PreventionType $preventionType): bool
    {
        return $user->can(config('perm.medical.preventionType.delete'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PreventionType $preventionType): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PreventionType $preventionType): bool
    {
        return false;
    }
}
