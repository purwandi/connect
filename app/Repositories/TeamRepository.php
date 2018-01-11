<?php

namespace App\Repositories;

use App\User;
use App\Group;
use App\Team;
use App\Exceptions\InvalidErrorPermissionException;
use Illuminate\Support\Facades\DB;

class TeamRepository
{

    /**
     * Get all team by given group id
     *
     * @param Group $group
     * @param User $user
     * @return void
     */
    public function getAllTeamByGivenGroup(Group $group, User $user)
    {
        if ($user->isUserInGroup($group) === false) {
            throw new InvalidErrorPermissionException;
        }

        return $group->team()->get();
    }

    /**
     * Create team by given group
     *
     * @param Group $group
     * @param User $user
     * @param string $name
     * @return void
     */
    public function create(Group $group, User $user, string $name)
    {
        if ($user->isUserInGroup($group) === false) {
            throw new InvalidErrorPermissionException;
        }

        return DB::transaction(function() use($group, $user, $name) {
            $team = $group->team()->create(['name' => $name]);

            $this->inviteUserIntoTeam($team, $user);

            return $team;
        });
    }

    /**
     * Invite a user into a team
     *
     * @param Team $team
     * @param User $user
     * @return void
     */
    public function inviteUserIntoTeam(Team $team, User $user)
    {
        $team->user()->sync($user);
    }
}