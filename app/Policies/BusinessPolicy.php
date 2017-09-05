<?php

namespace App\Policies;

use App\Business;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class BusinessPolicy
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

    /**
     * Determine if the given user can delete the given task.
     *
     * @param  User  $user
     * @param  Book  $book
     * @return bool
     */
    public function delete(User $user , Business $business)
    {
        return $user->id == $business->user_id;
    }

    public function edit(User $user, Business $business){

        return $user->id == $business->user_id;
    }
}
