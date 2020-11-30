<?php

namespace App\Policies;

use App\Models\Rank;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RankPolicy
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
     * @param  Rank  $rank
     * @return mixed
     */
    public function view(User $user, Rank $rank)
    {
        return $user->can('viewer');
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
     * @param  Rank  $rank
     * @return mixed
     */
    public function update(User $user, Rank $rank)
    {
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Rank  $rank
     * @return mixed
     */
    public function delete(User $user, Rank $rank)
    {
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  Rank  $rank
     * @return mixed
     */
    public function restore(User $user, Rank $rank)
    {
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  Rank  $rank
     * @return mixed
     */
    public function forceDelete(User $user, Rank $rank)
    {
    }
}
