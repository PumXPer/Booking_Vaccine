<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HospitalPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    function update(User $user)
    {
        return $user->isAdministrator();
    }

    function create(User $user)
    {
        // Same as update policy, we consider create is a special case of update.
        return $this->update($user);
    }

    function delete(User $user)
    {
        // Same as update policy, we consider delete is a special case of update.
        return $this->update($user);
    }
}
