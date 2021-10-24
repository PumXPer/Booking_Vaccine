<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Type;
use Illuminate\Auth\Access\HandlesAuthorization;

class TypePolicy
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

    function read(User $user)
    {
        return $this->update($user);
    }

    function create(User $user)
    {
        // Same as update policy, we consider create is a special case of update.
        return $this->update($user);
    }

    function delete(User $user, Type $type)
    {
        // to make sure there is vaccines_count.
        $type->loadCount('vaccines');
        return $this->update($user) && ($type->vaccines_count === 0);
    }
}
