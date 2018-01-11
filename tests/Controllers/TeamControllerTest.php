<?php

namespace Tests\Controllers;

use App\Repositories\GroupRepository;
use App\Repositories\TeamRepository;
use Mockery;

class TeamControllerTest extends AbstractControllerTest 
{
    public function test_get_all_team_by_given_group()
    {
        $groups = Mockery::mock(GroupRepository::class);
        $groups->shouldReceive('findById')->andReturn(
            \App\Group::make([ 'id' => 1, 'name' => 'Project', 'slug' => 'project', 'description' => 'Awesome project'])
        );

        $team1 = \App\Team::make(['name' => 'Developer']);
        $team1->id = 1;
        $team1->group_id = 1;
        $team2 = \App\Team::make(['name' => 'Kreatif']);
        $team2->id = 2;
        $team2->group_id = 1;

        $teams = Mockery::mock(TeamRepository::class);
        $teams->shouldReceive('getAllTeamByGivenGroup')->andReturn(collect([$team1, $team2]));

        $this->app->instance(GroupRepository::class, $groups);
        $this->app->instance(TeamRepository::class, $teams);

        $response = $this->actingAs(factory(\App\User::class)->make(), 'api')
            ->json('GET', '/api/groups/1/teams');
        
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    ['id' => 1, 'name' => 'Developer', 'group_id' => 1],
                    ['id' => 2, 'name' => 'Kreatif', 'group_id' => 1],
                ]
            ]);
    }

    public function test_get_all_empty_teams_by_given_group()
    {
        $groups = Mockery::mock(GroupRepository::class);
        $groups->shouldReceive('findById')->andReturn(
            \App\Group::make([ 'id' => 1, 'name' => 'Project', 'slug' => 'project', 'description' => 'Awesome project'])
        );

        $teams = Mockery::mock(TeamRepository::class);
        $teams->shouldReceive('getAllTeamByGivenGroup')->andReturn(collect([]));

        $this->app->instance(GroupRepository::class, $groups);
        $this->app->instance(TeamRepository::class, $teams);

        $response = $this->actingAs(factory(\App\User::class)->make(), 'api')
            ->json('GET', '/api/groups/1/teams');
        
        $response->assertStatus(200)
            ->assertJson([
                'data' => []
            ]);
    }


    public function test_get_all_empty_teams_by_wrong_group()
    {
        $groups = Mockery::mock(GroupRepository::class);
        $groups->shouldReceive('findById')->andReturn(
            \App\Group::make([ 'id' => 1, 'name' => 'Project', 'slug' => 'project', 'description' => 'Awesome project'])
        );

        $teams = Mockery::mock(TeamRepository::class);
        $teams->shouldReceive('getAllTeamByGivenGroup')->andThrow(\App\Exceptions\InvalidErrorPermissionException::class);

        $this->app->instance(GroupRepository::class, $groups);
        $this->app->instance(TeamRepository::class, $teams);

        $response = $this->actingAs(factory(\App\User::class)->make(), 'api')
            ->json('GET', '/api/groups/1/teams');
        
        $response->assertStatus(400);
    }

    public function test_create_team()
    {
        $groups = Mockery::mock(GroupRepository::class);
        $groups->shouldReceive('findById')->andReturn(
            \App\Group::make([ 'id' => 1, 'name' => 'Project', 'slug' => 'project', 'description' => 'Awesome project'])
        );

        $teams = Mockery::mock(TeamRepository::class);
        $teams->shouldReceive('create')
            ->andReturn((object) [ 'id' => 1,  'name' => 'Developer', 'group_id' => 1 ]);
        
        $group = Mockery::mock(\App\Contracts\GroupContract::class);
        
        $user = Mockery::mock(\App\Contracts\UserContract::class);
        $user->shouldReceive('isUserInGroup')->andReturn(true);

        $this->app->instance(GroupRepository::class, $groups);
        $this->app->instance(TeamRepository::class, $teams);

        $response = $this->actingAs(factory(\App\User::class)->make(), 'api')
            ->json('POST', '/api/groups/1/teams', [
                'name' => 'Developer',
            ]);
        
        $response->assertStatus(200);
    }

    public function test_create_team_invalid_data()
    {
        $groups = Mockery::mock(GroupRepository::class);
        $groups->shouldReceive('findById')->andReturn(
            \App\Group::make([ 'id' => 1, 'name' => 'Project', 'slug' => 'project', 'description' => 'Awesome project'])
        );

        $teams = Mockery::mock(TeamRepository::class);
        $teams->shouldReceive('create')
            ->andReturn((object) [ 'id' => 1,  'name' => 'Developer' ]);
        
        $group = Mockery::mock(\App\Contracts\GroupContract::class);
        
        $user = Mockery::mock(\App\Contracts\UserContract::class);
        $user->shouldReceive('isUserInGroup')->andReturn(true);

        $this->app->instance(GroupRepository::class, $groups);
        $this->app->instance(TeamRepository::class, $teams);
        $this->app->instance(\App\Contracts\GroupContract::class, $group);
        $this->app->instance(\App\Contracts\UserContract::class, $user);

        $response = $this->actingAs(factory(\App\User::class)->make(), 'api')
            ->json('POST', '/api/groups/1/teams', []);
        
        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'name' => 'The name field is required.'
                ]
            ]);
    }

    public function test_create_team_and_group_is_invalid()
    {
        $groups = Mockery::mock(GroupRepository::class);
        $groups->shouldReceive('findById')->andReturn(null);

        $teams = Mockery::mock(TeamRepository::class);
        $teams->shouldReceive('create')->andReturn(null);

        $this->app->instance(GroupRepository::class, $groups);
        $this->app->instance(TeamRepository::class, $teams);

        $response = $this->actingAs(factory(\App\User::class)->make(), 'api')
            ->json('POST', '/api/groups/1/teams', [
                'name' => 'Project name',
            ]);
        
        $response->assertStatus(404);
    }

    /**
     * @expectedExeption Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function test_unable_to_create()
    {
        $groups = Mockery::mock(GroupRepository::class);
        $groups->shouldReceive('findById')->andReturn(
            \App\Group::make([ 'id' => 1, 'name' => 'Project', 'slug' => 'project', 'description' => 'Awesome project'])
        );

        $teams = Mockery::mock(TeamRepository::class);
        $teams->shouldReceive('create')->andReturn(null);

        $this->app->instance(GroupRepository::class, $groups);
        $this->app->instance(TeamRepository::class, $teams);

        $response = $this->actingAs(factory(\App\User::class)->make(), 'api')
            ->json('POST', '/api/groups/1/teams', [
                'name' => 'Project name',
            ]);
        
        $response->assertStatus(400);
    }
}