<?php

namespace App\Policies\Medical;

use App\Models\Medical\Certificate;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PreventionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(config('perm.medical.certificate.view'));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Certificate $Certificate): bool
    {
        return $user->can(config('perm.medical.certificate.view'));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(config('perm.medical.certificate.create'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Certificate $Certificate): bool
    {
        return $user->can(config('perm.medical.certificate.update'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Certificate $Certificate): bool
    {
        return $user->can(config('perm.medical.certificate.delete'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Certificate $Certificate): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Certificate $Certificate): bool
    {
        return false;
    }
}
