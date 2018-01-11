<?php

namespace Tests\Controllers;

use Mockery;
use App\Repositories\GroupRepository;

class GroupControllerTest extends AbstractControllerTest 
{
    public function test_create_group()
    {
        $group = \App\Group::make([
            'name' => 'Project name',
            'slug' => 'project-name',
            'description' => 'Awesome project name',
        ]);
        $group->id = 1;

        $groups = Mockery::mock(GroupRepository::class);
        $groups->shouldReceive('create')->andReturn($group);

        $this->app->instance(GroupRepository::class, $groups);
        $response = $this->actingAs(factory(\App\User::class)->make(), 'api')
            ->json('POST', '/api/groups', [
                'name' => 'Project name',
                'description' => 'Awesome project name'
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => 1,
                    'name' => 'Project name',
                    'slug' => 'project-name',
                    'description' => 'Awesome project name',
                ]
            ]);
    }

    public function test_invalid_post_data()
    {
        $groups = Mockery::mock(GroupRepository::class);
        $groups->shouldReceive('create')->andReturn(null);

        $this->app->instance(GroupRepository::class, $groups);
        
        $response = $this->actingAs(factory(\App\User::class)->make(), 'api')
            ->json('POST','/api/groups');

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'name' => 'The name field is required.'
                ]
            ]);
    }
}