<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_team()
    {
        $user = factory(\App\User::class)->create();
        $group = (new \App\Repositories\GroupRepository)->create($user, 'Example group', 'About example group');
        $team = (new \App\Repositories\TeamRepository)->create($group, $user, 'Developer');

        $this->assertDatabaseHas('teams', [
            'name' => 'Developer',
            'group_id' => $group->id
        ]);

        $this->assertDatabaseHas('users_teams', [
            'team_id' => $team->id,
            'user_id' => $user->id
        ]);

        $this->assertDatabaseHas('users_teams', [
            'team_id' => $team->id,
            'user_id' => $user->id
        ]);

        $this->assertEquals([
            'group_id' => $group->id,
            'name' => $team->name
        ], [
            'group_id' => $group->id,
            'name' => 'Developer'
        ]);
    }

    /**
     * @expectedException \App\Exceptions\InvalidErrorPermissionException
     */
    public function test_can_not_create_team_if_user_not_belonging_the_group()
    {
        $user = factory(\App\User::class)->create();
        $user2 = factory(\App\User::class)->create();
        $group = (new \App\Repositories\GroupRepository)->create($user, 'Example group', 'About example group');
        $team = (new \App\Repositories\TeamRepository)->create($group, $user2, 'Developer');
    }

    public function test_get_all_team_by_given_group()
    {
        $user = factory(\App\User::class)->create();
        $group = (new \App\Repositories\GroupRepository)->create($user, 'Example group', 'About example group');
        $team = (new \App\Repositories\TeamRepository)->create($group, $user, 'Developer');

        $teams = (new \App\Repositories\TeamRepository)->getAllTeamByGivenGroup($group, $user);

        $this->assertEquals([['name' => 'Developer']], [['name' => $team->name]]);
    }

    /**
     * @expectedException \App\Exceptions\InvalidErrorPermissionException
     */
    public function test_failed_to_get_all_team_because_user_is_not_in_group()
    {
        $user = factory(\App\User::class)->create();
        $user2 = factory(\App\User::class)->create();
        $group = (new \App\Repositories\GroupRepository)->create($user, 'Example group', 'About example group');
        $team = (new \App\Repositories\TeamRepository)->create($group, $user, 'Developer');

        $teams = (new \App\Repositories\TeamRepository)->getAllTeamByGivenGroup($group, $user2);

        $this->assertEquals($teams, []);
    }
}