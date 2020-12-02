<?php

namespace App\Policies;

use App\Models\Rebuke;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RebukePolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if($user->can('moderator'))
            return true;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->can('viewer');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Rebuke  $rebuke
     * @return mixed
     */
    public function view(User $user, Rebuke $rebuke)
    {
        return $user->can('viewer') || $rebuke->user()->find($user->id);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Rebuke  $rebuke
     * @return mixed
     */
    public function update(User $user, Rebuke $rebuke)
    {
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Rebuke  $rebuke
     * @return mixed
     */
    public function delete(User $user, Rebuke $rebuke)
    {
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  Rebuke  $rebuke
     * @return mixed
     */
    public function restore(User $user, Rebuke $rebuke)
    {
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  Rebuke  $rebuke
     * @return mixed
     */
    public function forceDelete(User $user, Rebuke $rebuke)
    {
    }
}
