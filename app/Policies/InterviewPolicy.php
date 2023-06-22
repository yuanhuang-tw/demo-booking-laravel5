<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use App\Interview;

class InterviewPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     //
    // }

    public function before($user)
    {
        if ($user->isAdmin($user->id)) {
            return true;
        }
    }

    public function edit(User $user, Interview $interview)
    {
        if ($user->ac($user->id, $interview->user_id)) {
            return true;
        }

        return $user->id === (int)$interview->user_id;
    }

    public function update(User $user, Interview $interview)
    {
        if ($user->ac($user->id, $interview->user_id)) {
            return true;
        }

        return $user->id === (int)$interview->user_id;
    }

    public function destroy(User $user, Interview $interview)
    {
        if ($user->ac($user->id, $interview->user_id)) {
            return true;
        }

        return $user->id === (int)$interview->user_id;
    }

    public function upload(User $user, Interview $interview)
    {
        if ($user->ac($user->id, $interview->user_id)) {
            return true;
        }

        return $user->id === (int)$interview->user_id;
    }

    public function send_to_department_head(User $user, Interview $interview)
    {
        if ($user->ac($user->id, $interview->user_id)) {
            return true;
        }

        return $user->id === (int)$interview->user_id;
    }

    public function department_head_control(User $user, Interview $interview)
    {
        if ($user->isSalesAdmin($user->id) && $user->isSales($interview->user_id)) {
            return true;
        }

        if ($user->isMKTGAdmin($user->id) && $user->isMKTG($interview->user_id)) {
            return true;
        }

        if ($user->isProgAdmin($user->id) && $user->isProg($interview->user_id)) {
            return true;
        }
    }
}
