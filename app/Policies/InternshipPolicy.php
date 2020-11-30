<?php

namespace App\Policies;

use App\Models\Internship;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InternshipPolicy
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
     * @param  Internship  $internship
     * @return mixed
     */
    public function view(User $user, Internship $internship)
    {
        return $user->can('viewer') || $internship->user()->find($user->id);
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
     * @param  Internship  $internship
     * @return mixed
     */
    public function update(User $user, Internship $internship)
    {
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Internship  $internship
     * @return mixed
     */
    public function delete(User $user, Internship $internship)
    {
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  Internship  $internship
     * @return mixed
     */
    public function restore(User $user, Internship $internship)
    {
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  Internship  $internship
     * @return mixed
     */
    public function forceDelete(User $user, Internship $internship)
    {
    }
}
