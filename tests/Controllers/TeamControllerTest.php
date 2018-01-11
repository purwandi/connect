<?php

namespace Tests\Controllers;

use App\Repositories\GroupRepository;
use App\Repositories\TeamRepository;
use Mockery;

class TeamControllerTest extends AbstractControllerTest 
{
    public function test_create_team()
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